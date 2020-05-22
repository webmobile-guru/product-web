@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/coin/transaction.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/coin/transaction.Manage_Coin_Transaction')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/coin/transaction.Coin')}}
    <small>{{trans('admin/coin/transaction.Transaction_Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/coin/transaction.Search_By')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" method="get" action="{{ route('admin.coin.transaction') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{trans('admin/coin/transaction.Coin_Transaction_Date_Between')}}:</label>
                            <div class="input-group date-picker input-daterange">
                                <input type="text" class="form-control" name="from_date" value="{{ request()->from_date }}">
                                <span class="input-group-addon">{{trans('admin/coin/transaction.To')}}</span>
                                <input type="text" class="form-control" name="to_date" value="{{ request()->to_date }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/coin/transaction.Transaction_Hash')}}:</label>
                            <input type="text" name="transaction_id" value="{{ request()->transaction_id }}" class="form-control" placeholder="{{trans('admin/coin/transaction.Enter_Transaction_hash')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/coin/transaction.Address')}}:</label>
                            <input type="text" name="address" value="{{ request()->address }}" class="form-control" placeholder="{{trans('admin/coin/transaction.Enter_Coin_Address')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/coin/transaction.Coin')}}:</label>
                            <select name="coin_id" class="form-control">
                                <option value="">-- {{trans('admin/coin/transaction.Select_Coin')}} --</option>
                                @foreach($coins as $key => $value)
                                    <option value={{ $key }} @if(request()->coin_id == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/coin/transaction.Transaction_Type')}}:</label>
                            <select name="type" class="form-control">
                                <option value="">-- {{trans('admin/coin/transaction.Select_Type')}} --</option>
                                <option value="Debit" @if(request()->type == 'Debit') selected @endif>{{trans('admin/coin/transaction.Debit')}}</option>
                                <option value="Credit" @if(request()->type == 'Credit') selected @endif>{{trans('admin/coin/transaction.Credit')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/coin/transaction.Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/coin/transaction.Coin_Transaction_Management')}}</span>
                </div>            
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th class="text-center">{{trans('admin/coin/transaction.Date')}}  </th>                                
                                <th class="text-center">{{trans('admin/coin/transaction.Coin')}}  </th>
                                <th class="text-center" colspan="2">{{trans('admin/coin/transaction.Transaction_Details')}}  </th>                                                     
                                <th class="text-center">{{trans('admin/coin/transaction.Amount')}}  </th>
                                <th class="text-center">{{trans('admin/coin/transaction.Type')}}  </th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="text-center"> {{ $transaction->created_at }} </td>                                   
                                    <td class="text-center"> {{ $transaction->coin->coin }} </td>
                                    <td class="text-left">
					    @php $td = explode('#', $transaction->reference_no); @endphp					                                                                           
                                            @if(isset($td[1]))
					    	<strong>{{trans('admin/coin/transaction.Withdraw_ID')}}: </strong> {{ $td[0] }}<br/>
						<strong>{{trans('admin/coin/transaction.Transaction_ID')}}: </strong> {{ $td[1] }} <br/>
					    @else
					    	<strong>{{trans('admin/coin/transaction.Transaction_ID')}}: </strong> {{ $td[0] }} <br/>
					    @endif					   
					    <strong>{{trans('admin/coin/transaction.Address')}}: </strong>{{ $transaction->coin_address }} <br/>
					    <strong>{{trans('admin/coin/transaction.Email')}}:</strong>{{ $transaction->user->email }}                                                                               
                                    </td>
                                    <td class="text-center">  </td>                                  
                                    <td class="text-center"> {{ number_format($transaction->amount, 8) }} </td>
                                    <td class="text-center">
                                        @if($transaction->type == 'Credit') 
                                            <label class="label label-success">{{ ucfirst($transaction->type) }}</label> 
                                        @else
                                            <label class="label label-danger">{{ ucfirst($transaction->type) }}</label> 
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{trans('admin/coin/transaction.Data')}} </td>
                                </tr>
                            @endforelse
                            <tr> <td colspan="7" class="text-right">{{ $transactions->links() }}</td> </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

<script>
	$(document).ready(function(){
		$('td.hpopover').popover();
	});
</script>
<script>
    $('.date-picker').datepicker({
        orientation: "bottom",
        autoclose: true
    });
</script>
@endpush

