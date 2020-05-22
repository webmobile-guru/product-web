<?php

namespace App\Http\Controllers\Admin;

use App\Coin;
use App\CoinTransaction;
use App\Repository\User\UserRepository;
use App\Transaction;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $request = request();

        $query = $this->repository->latest();

        if($request->has('query')) {
            $query = $query
                ->where('email', $request->input('query'))
                ->orWhere('first_name', 'like', '%'.$request->input('query').'%')
                ->orWhere('last_name', 'like', '%'.$request->input('query').'%');
        }

        $users = $query->paginate(15)->appends($request->query());

        return view('admin.account.index',compact('users'));
    }

    public function show($account)
    { 
        $user = $this->repository->findOrFail($account);
        //$accounts = $user->depositAddress;
        $coins = Coin::all();
        return view('admin.account.show', compact(/*'accounts',*/'coins', 'user'));
    }
    
    public function showCreditForm($accounts)
    {
        $user = $this->repository->findOrFail($accounts);
        $coins = Coin::all();
        return  view('admin.account.credit', compact('user', 'coins'));
    }

    public function creditAmount(Request $request, $accounts)
    {
        $this->validate($request, [
            'coin.*' => 'numeric|min:0|nullable',
        ], [
            'coin.*.numeric' => 'Value should be numeric',
            'coin.*.min' => 'Amount should be a positive number'
        ]);

        try {
            $user = $this->repository->findOrFail($accounts);

            foreach($request->input('coin') as $key => $value)
            {
                if($value > 0) {
                    $cTransaction = null; $transaction = null;

                    $code = 'TXN'.str_random(13);
                    $transaction = [
                        'code' => $code,
                        'user_id' => $user->id,
                        'coin_id' => $key,
                        'amount' => $value,
                        'source' => 'deposit',
                        'type' => 'Credit',
                        'description'=> 'Amount deposit by system',
                        'status' => 1
                    ];

                    $transaction = Transaction::create($transaction);

                    $cTransaction = [
                        'user_id' => $user->id,
                        'coin_id' => $key,
                        'transaction_id' => $transaction->id,
                        'amount' => $value,
                        'type' => 'Credit',
                        'reference_no' => $code,
                        'coin_address' => 'SYSTEM_CREDIT',
                        'remarks' => 'Amount deposit by system',
                        'status' => 1
                    ];

                    CoinTransaction::create($cTransaction);
                }

            }

            flash()->success('Success! Amount credited into user wallet')->important();
        } catch (\Exception $exception) {
            Log::info('Error from credit amount '.$exception->getMessage());

            flash()->error('Error! Failed to credit amount in user wallet')->important();
        }

        return redirect()->back();
    }



    public function showDebitForm($accounts)
    {
        $user = $this->repository->findOrFail($accounts);
        $coins = Coin::all();

        return  view('admin.account.debit', compact('user', 'coins'));
    }

    public function debitAmount(Request $request, $accounts)
    {
        $this->validate($request, [
            'coin.*' => 'numeric|min:0|nullable',
        ], [
            'coin.*.numeric' => 'Value should be numeric',
            'coin.*.min' => 'Amount should be a positive number'
        ]);

        try {

            $user = $this->repository->findOrFail($accounts);

            foreach($request->input('coin') as $key => $value)
            {
                if($value > 0) {
                    $cTransaction = null; $transaction = null;
                    $code = 'TXN'.str_random(13);

                    $transaction = [
                        'code' => $code,
                        'user_id' => $user->id,
                        'coin_id' => $key,
                        'amount' => $value,
                        'source' => 'deduction',
                        'type' => 'Debit',
                        'description'=> 'Amount deducted by system',
                        'status' => 1
                    ];

                    $transaction = Transaction::create($transaction);

                    $cTransaction = [
                        'user_id' => $user->id,
                        'coin_id' => $key,
                        'transaction_id' => $transaction->id,
                        'amount' => $value,
                        'type' => 'Debit',
                        'remarks' => 'Amount deducted by system',
                        'reference_no' => $code,
                        'coin_address' => 'SYSTEM_DEBIT',
                        'status' => 1
                    ];

                    CoinTransaction::create($cTransaction);
                }
            }

            flash()->success('Success! Amount debited from user wallet');

        } catch (\Exception $exception) {
            Log::info('Error from debit amount '.$exception->getMessage());
            flash()->error('Error! Failed to debit amount from user wallet');
        }

        return redirect()->back();
    }
    
    public function toggleSwitch(Request $request)
    { 
        if(session()->has('mode')) {
            session()->forget('mode');
        } else {
            session()->put('mode', 'demo');
        }
         return redirect()->back();
    }
}
