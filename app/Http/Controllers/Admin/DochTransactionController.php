<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DochTransaction;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\CoinTransaction;
use DB;


class DochTransactionController extends Controller
{    
    public function transactions(){
        $transactions = DochTransaction::paginate(10);
        return view('admin.dochTransaction.transactions', compact('transactions'));
    }

    public function approveStatus($id)
    {
        $transactions = DochTransaction::findorFail($id);
        if($transactions->status==0){
            $transactions->status = 1;
            
            flash()->success('Success! Transaction has been Approved'); 

            $transaction = [
                'user_id' => $transactions->user_id,
                'coin_id' => $transactions->coin_id,
                'code' => uniqid('CPDEP').str_random(10),
                'type' => 'Credit',
                'source' => 'Etherium Network',
                'amount' => $transactions->amount,
                'description' => $transactions->amount.' Doch Deposited',
                'status' => 1
            ];

            $ctransaction = [
                'user_id' => $transactions->user_id,
                'coin_id' => $transactions->coin_id,
                'coin_address' => $transactions->address,
                'dest_tag' => null,
                'reference_no' => $transactions->transaction_hash,
                'amount' => $transactions->amount,
                'fees' => 0,
                'type' => 'Credit',
                'status' => 1,
                'remarks' => $transactions->amount.' Doch Deposited',
            ];

            DB::transaction(function() use ($ctransaction, $transaction,$transactions){
                $transactions->update(); 
                $t = Transaction::create($transaction);
                $ctransaction['transaction_id'] = $t->id;
                CoinTransaction::create($ctransaction);
            });
        }else{
            flash()->error('Invalid Attempt!!');
        }
            

        return redirect()->back();
    }

    public function denyStatus($id)
    {
        $transactions = DochTransaction::findorFail($id);
        if($transactions->status==0){           
            $transactions->status = 2;
            $transactions->update();  
            flash()->success('Success! Transaction has been Denied'); 
        }else{
            flash()->error('Invalid Attempt!!');
        }
        
        return redirect()->back();
    }
    }
