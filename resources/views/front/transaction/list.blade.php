@php $mode = session()->get('mode'); $mode = !($mode)?'live':$mode; @endphp
@extends('front.user')
@section('content')
@include('front.layout.user-header')
<section class="small_padding bg_color1">
    <div class="all_heading text-center">
        <h2>{{trans('front/transaction/list.Transactions')}}</h2>
      </div>
    <div class="container">
        <div class="card_shadow">
            
            <form name="search" method="get" action="{{route('transactions.getTransactions')}}">
                <div class="row">
                    
                    <div class="col-md-3 form-group">
                        <label for="coin" class="control-label">{{trans('front/transaction/list.Coin')}}</label>
                        <select name="coin" class="buy_sell_i md_input">
                            <option value="">{{trans('front/transaction/list.All')}}</option>
                            @foreach($coins as $coin)
                            <option value="{{ $coin->id }}" {{ (request()->coin==$coin->id)?"selected":"" }} >{{ $coin->coin }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="source" class="control-label">{{trans('front/transaction/list.Source')}}</label>
                        <select name="source" class="buy_sell_i md_input">
                            <option value="">{{trans('front/transaction/list.All')}}</option>
                            <option value="buy" {{ (request()->source=="buy")?"selected":"" }} >{{trans('front/transaction/list.Buy')}}</option>
                            <option value="deposit" {{ (request()->source=="deposit")?"selected":"" }} >{{trans('front/transaction/list.Deposit')}}</option>
                            <option value="sell" {{ (request()->source=="sell")?"selected":"" }} >{{trans('front/transaction/list.Sell')}}</option>
                            <option value="referral" {{ (request()->source=="referral")?"selected":"" }} >{{trans('front/transaction/list.Referral')}}</option>
                            
                        </select>
                        
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="type" class="control-label">{{trans('front/transaction/list.Type')}}</label>
                        <select name="type" class="buy_sell_i md_input">
                            <option value="">All</option>
                            <option value="Credit" {{ (request()->type=="Credit")?"selected":"" }} >{{trans('front/transaction/list.Credit')}}</option>
                            <option value="Debit" {{ (request()->type=="Debit")?"selected":"" }} >{{trans('front/transaction/list.Debit')}}</option>
                        </select>
                        
                    </div>
                    
                    <div class="col-md-3">
                        <label class="control-label">&nbsp;</label>
                        <button type="submit" class="btn btn-block buy_buy_btn" name="search" value="true">{{trans('front/transaction/list.Search')}}</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                
            <table class="table buy_order_table market_trade table-hover">
                    <thead>
                    <tr>
                        <th>{{trans('front/transaction/list.TransactionId')}}</th>
                        <th>{{trans('front/transaction/list.Coin')}}</th>
                        <th>{{trans('front/transaction/list.Source')}}</th>
                        <th>{{trans('front/transaction/list.Type')}}</th>
                        <th>{{trans('front/transaction/list.Amount')}}</th>
                        <th>{{trans('front/transaction/list.Description')}}</th>
                        <th>{{trans('front/transaction/list.Date')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        @php
                            $coin = $transaction->coin;
                        @endphp
                            <tr>
                                <td>{{ $transaction->code }}</td>
                                <td>{{ $coin['coin'] }}</td>
                                <td>{{ ucfirst($transaction->source) }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ number_format($transaction->amount,8) }}</td>
                                <td>{{ $transaction->description }}</td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="7">{{trans('front/transaction/list.No_Transaction_Found')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {!! $transactions->links("pagination::bootstrap-4") !!}
            </div>
        </div>
    </div>
</section>


@endsection
@push('js')

@endpush

