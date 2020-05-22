<?php

namespace App\Http\Controllers\Admin;

use App\Coin;
use App\CoinPair;
use App\Payback;
use App\User;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repository\Report\ReportRepository;


class ReportController extends Controller
{
    public function transaction(Transaction $transaction, Coin $coin)
    {
        $query = $transaction->latest();

        $request = request();
        if(strcasecmp($request->get('search'), 'true') == 0)
        {
            if($request->input('from_date') && $request->input('to_date')) {

                $dates = [
                    Carbon::parse($request->from_date)->toDateTimeString(),
                    Carbon::parse($request->to_date.' 23:59:59')->toDateTimeString()
                ];

                $query = $query->whereBetween('transactions.created_at', $dates);
            }

            if($request->input('transaction_id')) {
                $query = $query->where('transactions.code', 'like', '%'.$request->transaction_id.'%');
            }

            if($request->input('user_info')) {

                $info = $request->user_info;

                $query = $query->whereHas('user', function($query) use ($info) {
                    $query->whereHas('profile', function($q) use ($info){
                        $q->where('profiles.role', $info)
                            ->orWhere('profiles.phone', $info);
                    })->where('users.first_name', 'like', "%".$info."%")
                        ->orWhere('users.last_name', 'like', "%".$info."%")
                        ->orWhere('users.email', '=', $info);
                });
            }

            if($request->input('source')) {
                $query = $query->where('transactions.source', '=', $request->source);
            }

            if($request->input('coin_id')) {
                $query = $query->where('transactions.coin_id', '=', $request->coin_id);
            }

            if($request->input('type')) {
                $query = $query->where('transactions.type', '=', ucfirst($request->type));
            }
        }

        $transactions = $query->paginate(20)->appends($request->query());
        $coins = $coin->pluck('name', 'id');
        $source = $transaction->distinct()->pluck('source');

        return view('admin.report.transaction',compact('transactions', 'coins', 'source'));
    }

    public function getTradeSummary(ReportRepository $repository)
    {
        $request = request(); $search = [null, null, null, null];
        if(strcasecmp($request->get('search'), 'true') == 0)
        {
            if($request->input('user_info')) {
                $search[0] = $request->input('user_info');
            }

            if($request->input('pair')) {
                $search[1] = $request->input('pair');
            }

            if($request->input('start_date')) {
                $search[2] = Carbon::parse($request->input('start_date'));
            }

            if($request->input('end_date')) {
                $search[3] = Carbon::parse($request->input('end_date'));
            }
        } 
        
        $pairs = CoinPair::pluck('pair_name', 'id');
        $results = $repository->getTradeSummary($search);
        
        return view('admin.report.trade-summary', compact('results', 'pairs'));
    }

    public function getPaybackSummary()
    {
        $pairs = CoinPair::pluck('pair_name', 'id');

        $query = Payback::latest();

        $request = request();

        if(strcasecmp($request->get('search'), 'true') == 0)
        {
            if($fromDate = $request->get('from_date')) {
                $query = $query->whereDate('created_at', '>=', $fromDate);
            }

            if($toDate = $request->get('to_date')) {
                $query = $query->whereDate('created_at', '<=', $toDate);
            }

            if($pair = $request->input('pair')){
                $query = $query->where('paybacks.coin_pair_id', '=', $pair);
            }

            if($info = $request->get('user_info')) {
                $query = $query->whereHas('user', function($query) use ($info) {
                    $query->whereHas('profile', function($q) use ($info){
                        $q->where('profiles.role', 'like', "%".$info."%")
                            ->orWhere('profiles.phone', 'like', "%".$info."%");
                    })
                        ->where('users.first_name', 'like', "%".$info."%")
                        ->orWhere('users.last_name', 'like', "%".$info."%")
                        ->orWhere('users.email', '=', $info);
                });
            }

            if($rtype = $request->input('rtype')){
                $query = $query->where('paybacks.revert_type', '=', $rtype);
            }

            if($status = $request->input('status')){
                $query = $query->where('paybacks.status', '=', $status);
            }
        }


        $results = $query->paginate(10);

        return view('admin.report.payback', compact('pairs', 'results'));
    }
}
