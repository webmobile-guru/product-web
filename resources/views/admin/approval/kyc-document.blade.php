@inject('coins', 'App\Coin')
@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/approval/withdraw.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/approval/withdraw.Approve')}}</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/approval/withdraw.Kyc_Document')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/approval/withdraw.Approve')}}
    <small>{{trans('admin/approval/withdraw.Kyc_Document')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">{{trans('admin/approval/withdraw.Search_By')}}</div>
                </div>
                <div class="portlet-body flip-scroll">
                    <form role="form" method="get" action="{{ route('admin.approve.kyc') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{trans('admin/approval/withdraw.Document_Submission_Between')}}</label>
                                <div class="input-group date-picker input-daterange">
                                    <input type="text" class="form-control" name="from_date" value="{{ request()->from_date }}">
                                    <span class="input-group-addon">{{trans('admin/approval/withdraw.To')}}</span>
                                    <input type="text" class="form-control" name="to_date" value="{{ request()->to_date }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('admin/approval/withdraw.User_Name')}}</label>
                                <input type="text" name="user_info" value="{{ request()->user_info }}" class="form-control" placeholder="{{trans('admin/approval/withdraw.Enter_User_Info')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('admin/approval/withdraw.Date_of_Birth')}}</label>
                                <input type="text" name="user_dob" value="{{ request()->user_info }}" class="form-control date-picker" placeholder="{{trans('admin/approval/withdraw.Enter_Date_of_Birth')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('admin/approval/withdraw.Status')}}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{trans('admin/approval/withdraw.Select_Status')}}</option>
                                    <option value="pending" @if(request()->status == 'pending') selected @endif>{{trans('admin/approval/withdraw.Pending')}}</option>
                                    <option value="approved" @if(request()->status == 'approved') selected @endif>{{trans('admin/approval/withdraw.Approved')}}</option>
                                    <option value="rejected" @if(request()->status == 'rejected') selected @endif>{{trans('admin/approval/withdraw.Rejected')}}</option>                                    
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/approval/withdraw.Search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/approval/withdraw.Approve_Withdraw')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Date')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Email')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.FirstName')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.MiddleName')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.LastName')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Date_of_Birth')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Status')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @forelse($documents as $document)   
                                    <tr>
                                        <td class="text-center">{{ $document->created_at->toFormattedDateString() }}</td>
                                        <td class="text-center">{{ $document->user->email }}</td>
                                        <td class="text-center">{{ $document->first_name }}</td>
                                        <td class="text-center">{{ $document->middle_name }}</td>
                                        <td class="text-center">{{ $document->last_name }}</td>
                                        <td class="text-center">{{ Carbon\Carbon::parse($document->dob) }}</td>
                                        <td class="text-right text-{{['warning', 'success', 'danger'][ $document->status]}}">{{ ["Pending", "Approved", "Rejected"][ $document->status] }}</td>
                                        <td class="text-center" width="25%">
                                            <a href="{{ route('admin.approve.kyc.show', $document->code) }}" class="btn btn-success btn-sm" title="Approve">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-danger">{{trans('admin/approval/withdraw.No_Withdraw')}}</td>
                                    </tr>
                                @endforelse
                                <tr> <td colspan="8" class="text-right">{{ $documents->links() }}</td> </tr>
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
<script type="text/javascript">
    $(document).ready(function(){

        $('.date-picker').datepicker({
            orientation: "bottom",
            autoclose: true
        });        
    });
</script>
@endpush
