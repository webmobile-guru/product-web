<?php

namespace App\Http\Controllers;

use App\User;
use App\CoinTransaction;
use App\DepositAddress;
use App\Transaction;
use App\Mail\DepositEmail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Mramitict\LaravelCoinpayments\Exceptions\IpnIncompleteException;


class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        //Log::info('Payment controller request data is '.$request->getContent());

        try {

            $ipn = \Coinpayments::validateIPNRequest($request);
            // do something with the completed transaction

            if($ipn->isDeposit()) {

                $query = CoinTransaction::where('reference_no', $ipn->descriptor->txn_id)
                    ->where('coin_address', $ipn->descriptor->address);

                if($request->has('dest_tag')){
                    $query->where('dest_tag', $request->input('dest_tag'));
                }

                if($query->exists() && $ipn->isComplete()) {
                    $query->update([
                        'fees' => $ipn->descriptor->fee,
                        'status' => 1,
                    ]);

                    $ct = $query->first();
                    
                    $user_mail= $ct->user->email;
					
					$user_data = array('coin'=> $ct->coin->coin,'amount'=>$ct->amount);

                    //Mail::to($user_mail)->send(new DepositEmail($user_data));

                    $netAmount = $ipn->descriptor->amount - $ipn->descriptor->fee;

                    $ct->transaction()->update([
                        'amount' => $ipn->descriptor->amount,
                        'status' => 1
                    ]);

                } else {
                    $query = DepositAddress::whereHas('coin', function($q) use ($ipn){
                        $q->where('coin', $ipn->descriptor->currency);
                    })->where('address', $ipn->descriptor->address);

                    if($request->has('dest_tag')){
                        $query->where('dest_tag', $request->input('dest_tag'));
                    }

                    if($query->exists()) {
                        $coinAddress = $query->first();

                        $amountSatoshi = $request->input('amounti');
						$netAmount = $ipn->descriptor->amount - $ipn->descriptor->fee;
                        $transaction = [
                            'user_id' => $coinAddress->user_id,
                            'coin_id' => $coinAddress->coin_id,
                            'code' => uniqid('CPDEP').str_random(10),
                            'type' => 'Credit',
                            'source' => 'coinpayment',
                            'amount' => $ipn->descriptor->amount,
                            'description' => $ipn->descriptor->currency
                                .' deposited worth of Satoshi '
                                .$amountSatoshi,
                            'status' => 1
                        ];

                        $ctransaction = [
                            'user_id' => $coinAddress->user_id,
                            'coin_id' => $coinAddress->coin_id,
                            'coin_address' => $ipn->descriptor->address,
                            'dest_tag' => $request->input('dest_tag'),
                            'reference_no' => $ipn->descriptor->txn_id,
                            'amount' => $ipn->descriptor->amount,
                            'fees' => $ipn->descriptor->fee,
                            'type' => 'Credit',
                            'status' => 1,
                            'remarks' => $ipn->descriptor->currency
                                .' deposited worth of Satoshi '
                                .$amountSatoshi,
                        ];

                        DB::transaction(function() use ($ctransaction, $transaction){
                            $t = Transaction::create($transaction);
                            $ctransaction['transaction_id'] = $t->id;
                            CoinTransaction::create($ctransaction);
                        });
                        
                        $user_query = User::where('id', $coinAddress->user_id); $userEmail=$user_query->first()->email; 
						$user_data=array('coin'=> $ipn->descriptor->currency,'amount'=>$ipn->descriptor->amount);

                        Mail::to($coinAddress->user)->send(new DepositEmail($user_data));
                    }
                }
            }
			

            if($ipn->isWithdrawal()) {
                $query = CoinTransaction::where('reference_no', $ipn->descriptor->ref_id)
                    ->where('coin_address', $ipn->descriptor->address);

                if($query->exists() && $ipn->isComplete()) {
                    $query->update([
                        'reference_no' => $ipn->descriptor->ref_id.'#'.$ipn->descriptor->txn_id,
                        'status' => 1
                    ]);

                    $query->update(['status' => 1]);

                }
            }

            if($ipn->isComplete()){
                Artisan::call('sync:balance');
            }

        } catch(IpnIncompleteException $e) {
            $ipn = $e->getIpn();

            if($ipn->isDeposit()) {
                $query = DepositAddress::whereHas('coin', function($q) use ($ipn){
                    $q->where('coin', $ipn->descriptor->currency);
                })->where('address', $ipn->descriptor->address);

                if($request->has('dest_tag')){
                    $query->where('dest_tag', $request->input('dest_tag'));
                }

                if($query->exists()) {

                    $q = CoinTransaction::where('reference_no', $ipn->descriptor->txn_id)
                    ->where('coin_address', $ipn->descriptor->address);

                    if(!$q->exists()){

                        $coinAddress = $query->first();

                        $amountSatoshi = $request->input('amounti');
                        $netAmount = $ipn->descriptor->amount - $ipn->descriptor->fee;

                        $transaction = [
                            'user_id' => $coinAddress->user_id,
                            'coin_id' => $coinAddress->coin_id,
                            'code' => uniqid('CPDEP').str_random(10),
                            'type' => 'Credit',
                            'source' => 'coinpayment',
                            'amount' => $ipn->descriptor->amount,
                            'description' => $ipn->descriptor->currency
                                .' deposited worth of Satoshi '
                                .$amountSatoshi,
                            'status' => 0
                        ];

                        $ctransaction = [
                            'user_id' => $coinAddress->user_id,
                            'coin_id' => $coinAddress->coin_id,
                            'coin_address' => $ipn->descriptor->address,
                            'dest_tag' => $request->input('dest_tag'),
                            'reference_no' => $ipn->descriptor->txn_id,
                            'amount' => $ipn->descriptor->amount,
                            'fees' => $ipn->descriptor->fee,
                            'type' => 'Credit',
                            'status' => 0,
                            'remarks' => $ipn->descriptor->currency
                                .' deposited worth of Satoshi '
                                .$amountSatoshi,
                        ];

                        DB::transaction(function() use ($ctransaction, $transaction){
                            $t = Transaction::create($transaction);
                            $ctransaction['transaction_id'] = $t->id;
                            CoinTransaction::create($ctransaction);
                        });

                    }

                    
                }
            }

            if($ipn->isWithdrawal()) {
		        $query = CoinTransaction::where('reference_no', $ipn->descriptor->ref_id)
                    ->where('coin_address', $ipn->descriptor->address);

                if($request->has('dest_tag')){
                    $query->where('dest_tag', $request->input('dest_tag'));
                }

                $query->update([
                    'reference_no' => $ipn->descriptor->ref_id
                ]);

                if($ipn->isFailed()) {
		            $ct = $query->first();
                    $ct->transaction()->delete();
                    $query->update(['status' => 2]);
                }
            }

        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }
}
