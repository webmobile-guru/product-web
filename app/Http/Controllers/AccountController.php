<?php

namespace App\Http\Controllers;

use App\Coin;
use App\CoinTransaction;
use App\DepositAddress;
use App\Repository\User\UserRepository;
use App\Repository\Wallet\Coinpayment;
use App\Repository\Wallet\WalletApp;
use App\Setting;
use App\Withdraw;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Transaction;
use App\Payment;
use App\SystemTokenWallet;
use App\SystemTokenTransaction;


class AccountController extends Controller
{
    protected $repository;

    const CUSTOM_COIN = 'DOCH';

    protected $coins;

    public function __construct(UserRepository $repository, Coin $coin)
    {
        $this->repository = $repository;

        $this->coins = $coin->pluck('coin')->toArray();
    }

    public function index()
    {
        $coins = Coin::active()->get(); $user = auth()->user();
        return view('front.account.index', compact('coins', 'user'));
    }
    
    public function toggleSwitch()
    {
        if(session()->has('mode')) {
            session()->forget('mode');
        } else {
            session()->put('mode', 'demo');
        }
        return redirect()->back();
    }

    public function getDeposit($coin)
    {
        $user = auth()->user();

        $dbCoin = Coin::where('coin', $coin)->first();
		$selfCoin = false;
        if($dbCoin->deposit_enabled) {
            /*if($coin == self::CUSTOM_COIN) {
                $query = $user->depositAddress()
                    ->whereHas('coin', function($query) use ($coin){
                        $query->whereCoin($coin);
                    });

                if($query->exists()) {

                    $coinAddress = $query->first();

                } else {

                    $wallet = new WalletApp();
                    $address = $wallet->getNewAddress();

                    $coin = Coin::whereCoin($coin)->first();

                    $addressData = [
                        'user_id' => $user->id,
                        'coin_id' => $coin->id,
                        'address' => trim($address)
                    ];

                    $user->depositAddress()->save(new DepositAddress($addressData));

                    $coinAddress = $query->first(); $coin = $coin->coin;
                }
            }*/ 
			if($coin == self::CUSTOM_COIN) {   
				//FIND USER ADDRESS
                //$coinAddress = uniqid();
                $query = $user->depositAddress()
                    ->whereHas('coin', function($query) use ($coin){
                        $query->whereCoin($coin);
                    });

                if($query->exists()) {

                    $coinAddress = $query->first();

                } else {
                    $url = env("DOCH_NETWORK_URL")."new-address";    
                    $headers = array("x-auth:DochCoin");

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $response = curl_exec ($ch);
                    $err = curl_error($ch);  //if you need
                    curl_close ($ch);

                    $dochAddressData = json_decode($response, true);
                    $coinAddress = $dochAddressData['address'];

                    $coinDetails = Coin::whereCoin($coin)->first();
                    $addressData = [
                        'user_id' => $user->id,
                        'coin_id' => $coinDetails->id,
                        'address' => trim($coinAddress),
                        'private_key' => $dochAddressData['privateKey']
                    ];

                    $user->depositAddress()->save(new DepositAddress($addressData));
                }
				$selfCoin = true;
            } elseif (in_array($coin, $this->coins)) {
                $coinAddress = $this->getAddress($coin);
            } else {
                $coinAddress = null;
            }
        } else {
            $coinAddress = null;
        }

        return view('front.account.deposit', compact('coinAddress', 'coin', 'selfCoin','dbCoin'));
    }

    private function getAddress($coin)
    {
        $user = auth()->user();

        $query = $user->depositAddress()
            ->whereHas('coin', function($query) use ($coin){
                $query->whereCoin($coin);
            });

        if(!$query->exists()) {

			try{
				$address = \Coinpayments::getCallbackAddress($coin);

				$coin = Coin::whereCoin($coin)->first();

				$addressData = [
					'user_id' => $user->id,
					'coin_id' => $coin->id,
					'address' => trim($address['address']),
					'dest_tag' => isset($address['dest_tag'])?trim($address['dest_tag']):null
				];

				$user->depositAddress()->save(new DepositAddress($addressData));

				$coinAddress = $query->first();
			}catch(\Exception $e){
                Log::error($e);
				$coinAddress = null;
			}

        } else {
            $coinAddress = $query->first();
        }

        return $coinAddress;
    }
    
    public function getHistory()
    {
        $user = auth()->user();

        $deposits = $user->coinTransaction()
            ->credit()->latest()

            ->paginate(10, ['*'], 'deposit')
            ->appends(request()->query());

        $withdraw = $user->coinTransaction()
            ->debit()->latest()
            ->paginate(10, ['*'], 'withdraw')
            ->appends(request()->query());

		return view('front.account.history',compact('deposits','withdraw'));
		
	}
	
	public function makeDeposit(Request $request, $currency)
    {
        switch($currency) {
            case 'usd' :
                return $this->usdDeposit($request);
            default :
                return redirect()->back();
        }
    }
    
	private function usdDeposit(Request $request)
    {
        $this->validate($request, [
            'payable_currency' => 'required|in:BTC,BCH,XMR,DASH,LTC,ETH,LTCT',
            'amount' => 'required|numeric'
        ]);

        $amount = $request->input('amount');
        $currencyToPay = $request->input('payable_currency'); 

        try {
            $cpTansaction = \Coinpayments::createTransactionSimple($amount, 'USD', $currencyToPay);

            $coin_id = Coin::where('coin', 'USD')->pluck('id')->first();

            $transaction = [
                'code' => $cpTansaction->txn_id,
                'user_id' => auth()->id(),
                'coin_id' => $coin_id,
                'type' => 'Credit',
                'source' => 'Coinpayment',
                'amount' => $amount,
            ];

            $payment = [
                'user_id' => auth()->id(),
                'address' => $cpTansaction->address,
                'reference_no' => $cpTansaction->txn_id,
                'remarks' => 'Deposit usd from coin payment api',
                'confirm' => 0
            ];


            DB::transaction(function() use ($transaction, $payment) {

                $transaction = Transaction::create($transaction);

                $payment['transaction_id'] = $transaction->id;

                Payment::create($payment);

            });

            return view('front.account.usd-deposited', compact('cpTansaction'));

        } catch (\Exception $exception) {

            Log::error('Error in creating coin transaction '.$exception->getMessage());

            return view('front.account.usd-deposited', compact('cpTansaction'));
        }
    }

    public function getWithdraw($coin)
    {
        $fees = Coin::where('coin', $coin)
            ->pluck('withdraw_fees')
            ->first();
			
		$user = auth()->user();
        $balance = $user->getBalance($coin);

        if($coin == 'USD') {
            return view('front.account.usd-withdraw', compact('coin'));
        }
        return view('front.account.withdraw', compact('coin', 'fees', 'balance'));
    }

    public function makeWithdraw(Request $request, $currency)
    {
        return $this->withdrawMoney($request, $currency);
    }

    public function withdrawMoney(Request $request, $currency)
    {
        $coin = Coin::where('coin', $currency)->first();
        $minAmount = $coin->withdraw_min_amount?:0;
        $maxAmount = $coin->withdraw_max_amount?:0;

        $rules = [
            'amount' => 'required|numeric|check_fund:'.$currency.'|between:'.$minAmount.','.$maxAmount,
            'address' => 'required'
        ];
		
		if(in_array($coin->coin, ['XRP','EOS'])){
			$rules += [
				'dest_tag' => 'required'
			];
		}

        $this->validate($request, $rules, [
            'amount.check_fund' => 'Your wallet doesn\'t have sufficient funds',
            'dest_tag.required' => 'Destination tag  is a required field',
        ]);

        $amount = $request->input('amount');
        $address = $request->input('address');
        $dest_tag = $request->input('dest_tag');

        try {

            $user = auth()->user();
            $balance = $user->getBalance($currency);

            if( $amount > $balance ) {
                throw new \Exception('Error! You don\'t have sufficient fund');
            }

            if(!$coin->withdraw_enabled){
                throw new \Exception('Error! Withdraw of coin has been closed temporarily');
            }

            $fee = $coin->withdraw_fees?:0;
            $fee = $amount*($fee/100);
            $netAmount = $amount - $fee;
			
			// $ide_verify=$user->profiles->ide_verify;
			// if(!$ide_verify){
			// 	$wthdrw= $this->withdrawAmountChecking($coin->coin,$amount);
			// 	if(!$wthdrw){
			// 		$result = ['status' => false, 'message' => 'Error! Your daily withdrawal limit exceeded.'];
			// 		return json_encode($result);
			// 	}
			// }

            $transaction = [
                'code' => uniqid('WTH').str_random(10),
                'user_id' => $user->id,
                'coin_id' => $coin->id,
                'source' => 'withdraw',
                'type' => 'Debit',
                'amount' => $amount,
                'description' => 'Withdraw request made',
                'status' => 1
            ];

            $withdraw = [
                'user_id' => $user->id,
                'coin_id' => $coin->id,
                'address' => $address,
				'dest_tag' => $dest_tag,
                'amount' => $amount,
                'fees' => $fee,
                'remarks' => 'Withdraw of '.$coin->coin.' '
                    .$amount.' in '.$currency.' '.$amount,
            ];

            $coinTransaction = [
                'user_id' => $user->id,
                'coin_id' => $coin->id,
                'coin_address' => $address,
		        'dest_tag' => $dest_tag,
                'amount' => $amount,
                'fees' => $fee,
                'type' => 'Debit',
                'remarks' => 'Withdraw of '.$coin->coin.' '.$amount.' in '.$coin->coin,
                'status' => 0
            ];
            
            
			if($coin->autoWithdraw() || $user->profile->withdraw_enable_auto) {
                if($coin->coin == self::CUSTOM_COIN) {
                    $returnData = $this->autoWithdrawDoch($withdraw);
					if(!$returnData){
						$result = [
							'status' => false,
							'message' => 'Error! There is an error creating auto withdraw request for doch. Please try after sometime.'
						];
						return json_encode($result);
					}
					
					$coinTransaction['reference_no'] = $returnData['msg'];
					$coinTransaction['status'] = 0;
					$transaction['code'] = $returnData['msg'];
					$withdraw['status'] = 1;
					$from = SystemTokenWallet::where('token',"DOCH")->pluck('address')->first();
					if(!SystemTokenTransaction::where('address',$from)->where('txn',$returnData['msg'])->exists()){
						SystemTokenTransaction::create([
							'token'=>"DOCH", 
							'address'=>$from, 
							'txn'=>$returnData['msg'], 
							'amount'=>$withdraw['amount'] - $withdraw['fees'], 
							'status'=>0, 
							'type'=>'debit'
						]);
					}
                } else {
                    
                    $cpRequest = \Coinpayments::createWithdrawal($netAmount, $coin->coin, $address, $dest_tag, true);  
                    $coinTransaction['reference_no'] = $cpRequest->ref_id;
					$withdraw['status'] = 1;
                }
                $txn = DB::transaction(function() use ($transaction, $withdraw, $coinTransaction){
                    $t = Transaction::create($transaction);
                    $coinTransaction['transaction_id'] = $t->id;
                    $ct = CoinTransaction::create($coinTransaction);
                    $withdraw['coin_transaction_id'] = $ct->id;
                    $withdraw['transaction_id'] = $t->id;
                    Withdraw::create($withdraw);
                    return $ct->reference_no;
                });
                $result = ['status' => true, 'message' => 'Success! TXN- '.$txn];
            } else {  
                DB::transaction(function() use ($transaction, $withdraw, $coinTransaction){
                    $t = Transaction::create($transaction);
					$coinTransaction['transaction_id'] = $t->id;
					$ct = CoinTransaction::create($coinTransaction);

                    $withdraw['coin_transaction_id'] = $ct->id;
                    $withdraw['status'] = 0;
                    $withdraw['transaction_id'] = $t->id;
                    Withdraw::create($withdraw);
                });
                $result = ['status' => true, 'message' => 'Success! Withdraw done. Amount will be reflect on address soon'];
            }
            
        } catch (QueryException $exception) {
            //Log::error($exception);
            $result = ['status' => false, 'message' => 'Error! There is an error creating withdraw request'];
        } catch (\Exception $exception) {
            //Log::error($exception);
            $result = [
                'status' => false,
                //'message' => 'Error! There is an error creating withdraw request. Please try after sometime.'
                'message'=>$exception->getMessage()
            ];
        }

        return json_encode($result);
    }
    
    public function withdrawAmountChecking($coin,$amount){
		
		//~ $totalwithdrawl=auth()->user()->withdraw->whereDate('created_at','=', Carbon::today())->sum('amount'); dd($totalwithdrawl);
		try {
			$user=auth()->user();
			$totalwithdrawl=Withdraw::whereDate('created_at','=', Carbon::today())->where('user_id',$user->id)->sum('amount'); 
			$daily_wihdrawl=$totalwithdrawl+$amount; 
			$usd_detail = DB::table('price_quotes')->where('symbol', $coin)->where('status', 1)->latest()->first();
			$usd_amount = ($usd_detail->price)*$daily_wihdrawl;  
			if($usd_amount <= 10000){
				return true;
			}else{
				return false;
			}
		}catch(\Exception $exception){
            return false;
		}
    }
	
	public function autoWithdrawDoch($withdrawRequest){

		$system_Balance = DB::select('call sp_get_token_balance(?)',['DOCH']);
		if($system_Balance < $withdrawRequest['amount']){
				return false;
		}
			
		$transactionAmount = ($withdrawRequest['amount'] - $withdrawRequest['fees']);
		$to = $withdrawRequest['address'];
		$from = SystemTokenWallet::where('token',"DOCH")->pluck('address')->first();
		$private_key = SystemTokenWallet::where('token',"DOCH")->pluck('private-key')->first();
		$value = $transactionAmount;

		$postData = [
			"value"=>(string)$value,
			"from"=>["address"=>$from, "privateKey"=>$private_key],
			"to"=>$to
		];
		
		$payload = json_encode($postData);
		$url = env("DOCH_NETWORK_URL")."transferToken/";
		$headers = array("x-auth:DochCoin",'Content-Type: application/json', 'Content-Length: ' . strlen($payload));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec ($ch);
		$err = curl_error($ch);  //if you need
		curl_close ($ch);

		$returnData = json_decode($response, true);
		if($returnData['status']=="Success"){
			return $returnData;
		}
		
		return false;		

	}
    
}
