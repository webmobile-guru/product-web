@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/report/transaction.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/report/transaction.Report')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/report/transaction.Transaction')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/report/transaction.Transaction')}}
    <small>{{trans('admin/report/transaction.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/report/transaction.Search_By')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" method="get" action="{{ route('admin.report.transaction') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{trans('admin/report/transaction.Transaction_Date_Between')}}:</label>
                            <div class="input-group date-picker input-daterange">
                                <input type="text" class="form-control" name="from_date" value="{{ request()->from_date }}">
                                <span class="input-group-addon">{{trans('admin/report/transaction.To')}}</span>
                                <input type="text" class="form-control" name="to_date" value="{{ request()->to_date }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/transaction.Transaction_ID')}}:</label>
                            <input type="text" name="transaction_id" value="{{ request()->transaction_id }}" class="form-control" placeholder="{{trans('admin/report/transaction.Enter_Transaction_hash')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/transaction.User')}}:</label>
                            <input type="text" name="user_info" value="{{ request()->user_info }}" class="form-control" placeholder="{{trans('admin/report/transaction.Enter_User_Info')}}">
                        </div>
                        <div class="col-md-3">
                            <label for="">{{trans('admin/report/transaction.Source')}}:</label>
                            <select name="source" class="form-control">
                                <option value="">-- {{trans('admin/report/transaction.Select_source')}} --</option>
                                @foreach($source as $value)
                                    <option value={{ $value }} @if(request()->source == $value) selected @endif>{{ ucfirst($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{trans('admin/report/transaction.Coin')}}:</label>                            
                            <select name="coin_id" class="form-control">
                                <option value="">-- {{trans('admin/report/transaction.Select_Coin')}} --</option>
                                @foreach($coins as $key => $value)
                                    <option value={{ $key }} @if(request()->coin_id == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">{{trans('admin/report/transaction.Transaction_Type')}}:</label>
                            <select name="type" class="form-control">
                                <option value="">-- {{trans('admin/report/transaction.Select_Type')}} --</option>
                                <option value="credit" @if(request()->type == 'credit') selected @endif>{{trans('admin/report/transaction.Credit')}}</option>
                                <option value="debit" @if(request()->type == 'debit') selected @endif>{{trans('admin/report/transaction.Debit')}}</option>
                            </select>
                        </div>                                                            
                        <div class="col-md-3">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/report/transaction.Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/report/transaction.User_Transaction_Management')}}</span>
                </div>
                {{ $transactions->links() }}           
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">{{trans('admin/report/transaction.Date')}}</th>
                                <th class="text-center">{{trans('admin/report/transaction.User')}}</th>
                                <th class="text-center">{{trans('admin/report/transaction.Transaction_ID')}}</th>
                                <th class="text-center">{{trans('admin/report/transaction.Coin')}}</th>
                                <th class="text-center">{{trans('admin/report/transaction.Type')}}</th>
                                <th class="text-center">{{trans('admin/report/transaction.Amount')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}</td>
                                    <td class="text-center">{{ $transaction->user->email }}</td>
                                    <td class="text-center">{{ $transaction->code }}</td>
                                    <td class="text-center">{{ $transaction->coin->name }}</td>
                                    <td class="text-center">{{ ucfirst($transaction->type) }}</td>
                                    <td class="text-right">{{ number_format($transaction->amount, 8) }}</td>
                                </tr>
                            @empty
                                <tr> 
                                    <td colspan="6" class="text-center text-danger">{{trans('admin/report/transaction.No_Transaction')}}!</td>
                                </tr>
                            @endforelse
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
    $('.date-picker').datepicker({
        orientation: "bottom",
        autoclose: true
    });
</script>
@endpush
