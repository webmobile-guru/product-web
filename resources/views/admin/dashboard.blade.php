@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('admin/dashboard.Dashboard')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/dashboard.Control')}}
    <small>{{trans('admin/dashboard.Panel')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    @php
        $colors = [
            'purple', 'blue', 'green', 'yellow', 'red',
            'green-seagreen', 'red-intense', 'grey-cascade'
        ];
    @endphp
    @foreach(App\Coin::all() as $coin)
        @php
			$coinDeposit = $coin->getDeposit();
			$coinWithdraw = $coin->getWithdrawal();
			$coinBalance = $coinDeposit - $coinWithdraw;
		@endphp
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 {{ $colors[array_rand($colors)] }}" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" style="font-size: 18px;" data-value="1349">{{ number_format($coinDeposit,8) }}</span>
                    </div>
                    <div class="desc uppercase"> {{$coin->coin}} {{trans('admin/dashboard.Deposit')}} </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 {{ $colors[array_rand($colors)] }}" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" style="font-size: 18px;" data-value="1349">{{ number_format($coinWithdraw,8) }}</span>
                    </div>
                    <div class="desc uppercase"> {{$coin->coin}} {{trans('admin/dashboard.Withdraw')}} </div>
                </div>
            </a>
        </div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 {{ $colors[array_rand($colors)] }}" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" style="font-size: 18px;" data-value="1349">{{ number_format($coinBalance,8) }}</span>
                    </div>
                    <div class="desc uppercase"> {{ $coin->coin }} {{trans('admin/dashboard.System_Balance')}} </div>
                </div>
            </a>
        </div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 {{ $colors[array_rand($colors)] }}" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" style="font-size: 18px;" data-value="1349">{{ $coin->getBalance() }}</span>
                    </div>
                    <div class="desc uppercase"> {{ $coin->coin }} {{trans('admin/dashboard.Server_Balance')}} </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection


