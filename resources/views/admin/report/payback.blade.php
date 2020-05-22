@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/report/payback.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/report/payback.Report')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/report/payback.Payback')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/report/payback.Payback')}}
    <small>{{trans('admin/report/payback.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/report/payback.Search_By')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" method="get" action="{{ route('admin.report.payback') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{trans('admin/report/payback.Payback_Date_Between')}}:</label>
                            <div class="input-group date-picker input-daterange">
                                <input type="text" class="form-control" name="from_date" value="{{ request()->from_date }}">
                                <span class="input-group-addon">{{trans('admin/report/payback.To')}}</span>
                                <input type="text" class="form-control" name="to_date" value="{{ request()->to_date }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/payback.User')}}:</label>
                            <input type="text" name="user_info" value="{{ request()->user_info }}" class="form-control" placeholder="{{trans('admin/report/payback.Enter_User_Info')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/payback.Coin_Pair')}}:</label>
                            <select name="pair" class="form-control">
                                <option value="">-- {{trans('admin/report/payback.Select_Coinpair')}} --</option>
                                @foreach($pairs as $key => $value)
                                    <option value={{ $key }} @if(request()->source == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/payback.Revert_Type')}}:</label>
                            <select name="rtype" class="form-control">
                                <option value="">-- {{trans('admin/report/payback.Select_Revert_Type')}} --</option>
                                <option value="fees">{{trans('admin/report/payback.Fees')}}</option>
                                <option value="profit">{{trans('admin/report/payback.Profit')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/report/payback.Status')}}:</label>
                            <select name="status" class="form-control">
                                <option value="">-- {{trans('admin/report/payback.Select_Status')}} --</option>
                                <option value="0" @if(request()->status == "0") selected @endif>{{trans('admin/report/payback.Unpaid')}}</option>
                                <option value="1" @if(request()->status == "1") selected @endif>{{trans('admin/report/payback.Paid')}}</option>
                            </select>
                        </div>                                                            
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/report/payback.Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/report/payback.Member_Payback_Management')}}</span>
                </div>
                {{--{{ $transactions->links() }} --}}
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">{{trans('admin/report/payback.Date')}}</th>
                                <th class="text-center">{{trans('admin/report/payback.User')}}</th>
                                <th class="text-center">{{trans('admin/report/payback.Coin_Pair')}}</th>
                                <th class="text-center">{{trans('admin/report/payback.Revert_Info')}}</th>
                                <th class="text-center">{{trans('admin/report/payback.Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->created_at)->toFormattedDateString() }}</td>
                                    <td class="text-center">{{ $record->user->email }}</td>
                                    <td class="text-center">{{ $record->coinPair->pair_name }}</td>
                                    <td>
                                        <p><b>{{trans('admin/report/payback.Revert_Type')}} : </b>{{ ucfirst($record->revert_type) }}</p>
                                        <p><b>{{trans('admin/report/payback.Base_Volume')}} : </b>{{ $record->volume }}</p>
                                        <p><b>{{trans('admin/report/payback.Fee_Collected')}} : </b>{{ $record->fees }}</p>
                                        <p><b>{{trans('admin/report/payback.Conversion_Rate')}} : </b>{{ $record->rate_in_usd }}</p>
                                        <p><b>{{trans('admin/report/payback.Base_Volume_USD')}} : </b><span class="text-info">{{ $record->volume_in_usd }}</span></p>
                                        <p><b>{{trans('admin/report/payback.Payback_Amount_USD')}} : </b><span class="text-danger">{{ $record->usd_to_revert }}</span></p>
                                    </td>
                                    <td class="text-center">{{ ['Unpaid', 'Paid'][$record->status] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">{{trans('admin/report/payback.Data_doesnot_exists')}}</td>
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
<style type="text/css">
    tr td p { margin-bottom: 5px; }
</style>
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
