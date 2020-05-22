<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\User\UserRepository;
use App\Transaction;
use App\Coin;

class TransactionController extends Controller
{
    public function toggleSwitch()
    {
        if(session()->has('mode')) {
            session()->forget('mode');
        } else {
            session()->put('mode', 'demo');
        }
        return redirect()->back();
    }

    public function getTransactions(){
        $user = auth()->user();

        $coins = Coin::where('status',1)->get();

        $transactions = $user->transaction();//->latest()->paginate(10);//return $transactions;

        if(request('coin')){

            $transactions->where('coin_id',request('coin'));					
        }

        if(request('source')){

            $transactions->where('source',request('source'));					
        }

        if(request('type')){

            $transactions->where('type',request('type'));					
        }

        $transactions = $transactions->latest()->paginate(10);

         return view('front.transaction.list',compact('transactions','coins'));
    }
}
