@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/report/trade-summary.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/report/trade-summary.Report')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/report/trade-summary.Trade_Summary')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/report/trade-summary.Trade_Summary')}}
    <small>{{trans('admin/report/trade-summary.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/report/trade-summary.Search_By')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" method="get" action="{{ route('admin.report.tsummary') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{trans('admin/report/trade-summary.Trade_Summary_Between')}}:</label>
                            <div class="input-group date-picker input-daterange">
                                <input type="text" class="form-control" name="start_date" value="{{ request()->start_date }}">
                                <span class="input-group-addon">{{trans('admin/report/trade-summary.To')}}</span>
                                <input type="text" class="form-control" name="end_date" value="{{ request()->end_date }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/trade-summary.User')}}:</label>
                            <input type="text" name="user_info" value="{{ request()->user_info }}" class="form-control" placeholder="{{trans('admin/report/trade-summary.Enter_User_Info')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/trade-summary.Coin_Pair')}}:</label>
                            <select name="pair" class="form-control">
                                <option value="">-- {{trans('admin/report/trade-summary.Select_source')}} --</option>
                                @foreach($pairs as $key => $pair)
                                    <option value={{ $key }} @if(request()->pair == $key) selected @endif>{{ $pair }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/report/trade-summary.Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/report/trade-summary.Trade_Summary_Report')}}</span>
                </div>
                {{--{{ $transactions->links() }} --}}
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">{{trans('admin/report/trade-summary.User')}}</th>
                                <th class="text-center">{{trans('admin/report/trade-summary.Coin_Pair')}}</th>
                                <th class="text-center">{{trans('admin/report/trade-summary.Total_Base_Volume')}}</th>
                                <th class="text-center">{{trans('admin/report/trade-summary.Base_Fee_Collected')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $record)
                                <tr>
                                    <td>{{ $record->email }}</td>
                                    <td>{{ $record->pair_name }}</td>
                                    <td class="text-right">{{ $record->volume }}</td>
                                    <td class="text-right">{{ $record->fees  }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-danger">{{trans('admin/report/trade-summary.Data_doesnot_exists')}}</td>
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
