<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DochTransaction;
use Illuminate\Support\Facades\Log;
use App\DepositAddress;
use App\Transaction;
use App\CoinTransaction;
use App\SystemTokenWallet;
use App\SystemTokenTransaction;
use App\TokenTransferLog;
use DB;

class DochTransactionController extends Controller
{
    public function saveTransactionHash(Request $request){
        $this->validate($request, [
            'transaction_hash' => 'required|unique:doch_transactions,transaction_hash',
            'address' => 'required',
            'amount' => 'required|numeric'
        ]);

        try{
            $user=auth()->user();
            $DochTransaction = new DochTransaction;
            $DochTransaction->user_id           = $user->id;
            $DochTransaction->coin_id           = $request->coin_id;
            $DochTransaction->address           = $request->address;
            $DochTransaction->transaction_hash  = $request->transaction_hash;
            $DochTransaction->amount            = $request->amount;
            $DochTransaction->status            = 0;

            $DochTransaction->save();
            
            echo 'success';die;
        }catch (\Exception $exception) {
            echo $exception->getMessage();die;
        }
            

    }

    public function receivedDochTransaction(Request $request){
        
        //Log::useFiles(storage_path().'/logs/mycustom.log');
        //Log::info($request);
        if(isset($request['transactionHash'])){

            $hashTxn = $request['transactionHash'];
            $address = $request['returnValues']['to'];
            $addressFrom = $request['returnValues']['from'];
            $value   = (float)$request['TokenValue'];
            $tokenName = $request['TokenName'];

            $checkHashExists = CoinTransaction::where('coin_address',$address)->where('reference_no',$hashTxn)->where('type','Credit');

            if(!$checkHashExists->exists()){
                $userBelongstoAddress = DepositAddress::where('address',$address)->first();
                if($userBelongstoAddress){
                    $transaction = [
                        'user_id' => $userBelongstoAddress->user_id,
                        'coin_id' => 12,
                        'code' => uniqid('CPDEP').str_random(10),
                        'type' => 'Credit',
                        'source' => 'Etherium Network',
                        'amount' => $value,
                        'description' => $value.' Doch Deposited',
                        'status' => 1
                    ];
            
                    $ctransaction = [
                        'user_id' => $userBelongstoAddress->user_id,
                        'coin_id' => 12,
                        'coin_address' => $address,
                        'dest_tag' => null,
                        'reference_no' => $hashTxn,
                        'amount' => $value,
                        'fees' => 0,
                        'type' => 'Credit',
                        'status' => 1,
                        'remarks' => $value.' Doch Deposited',
                    ];
            
                    DB::transaction(function() use ($ctransaction, $transaction){
                        $t = Transaction::create($transaction);
                        $ctransaction['transaction_id'] = $t->id;
                        CoinTransaction::create($ctransaction);
                    });
                }
            }

                ///internal transfer from admin/doch management
                $query = SystemTokenWallet::where('address',$address);
                if($query->exists()){
                    if(!SystemTokenTransaction::where('address',$address)->where('txn',$hashTxn)->exists()){
                        SystemTokenTransaction::create([
                            'token'=>$tokenName, 
                            'address'=>$address, 
                            'txn'=>$hashTxn, 
                            'amount'=>$value, 
                            'status'=>1, 
                            'type'=>'credit'
                        ]);

                        $q = TokenTransferLog::where('address',$address)->where('txn',$hashTxn);
                        if($q->exists()){
                            $q->update(['status'=>'completed']);
                        }
                    }
                }

                ///internal transfer from admin/doch management

                //system wallet debit transaction confirmation
                $qd = SystemTokenTransaction::where('address',$addressFrom)->where('txn',$hashTxn);
                if($qd->exists()){
                    $qd->update(['status'=>1]); 
                }

                //user receive confirmation

                $checkHashDebit = CoinTransaction::where('coin_address',$address)->where('reference_no',$hashTxn)->where('type','Debit');
                if($checkHashDebit->exists()){
                    $checkHashDebit->update(['status'=>1]);
                }

            
        }
        

        
    }
}

    
