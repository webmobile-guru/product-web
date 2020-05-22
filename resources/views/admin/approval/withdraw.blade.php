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
            <span>{{trans('admin/approval/withdraw.Withdraw')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/approval/withdraw.Approve')}}
    <small>{{trans('admin/approval/withdraw.Withdraw')}}</small>
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
                    <form role="form" method="get" action="{{ route('admin.approve.withdraw') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{trans('admin/approval/withdraw.Withdraw_Date_Between')}}</label>
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
                                <label for="">{{trans('admin/approval/withdraw.Coins')}}</label>
                                <select name="coin" class="form-control">
                                    <option value="">{{trans('admin/approval/withdraw.Select_Coin')}}</option>
                                    @php $coins = $coins->all() @endphp
                                    @foreach($coins as $coin)
                                        <option value="{{ $coin->id }}" @if(request()->coin == $coin->id) selected @endif>{{ $coin->coin }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{trans('admin/approval/withdraw.Status')}}</label>
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="pending" @if(request()->status == 'pending') selected @endif>{{trans('admin/approval/withdraw.Pending')}}</option>
                                    <option value="approved" @if(request()->status == 'approved') selected @endif>{{trans('admin/approval/withdraw.Approved')}}</option>
                                    <option value="rejected" @if(request()->status == 'rejected') selected @endif>{{trans('admin/approval/withdraw.Rejected')}}</option>
                                    <option value="canceled" @if(request()->status == 'canceled') selected @endif>{{trans('admin/approval/withdraw.Canceled')}}</option>
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
                                    <th class="text-center">{{trans('admin/approval/withdraw.User_Name')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Address')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Currency')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Amount')}}</th>
                                    <th class="text-center">{{trans('admin/approval/withdraw.Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>  
                            @forelse($withdraws as $withdraw)   
                                <tr data-id="{{ $withdraw->id }}">
                                    <td class="text-center">{{ $withdraw->created_at->toFormattedDateString() }}</td>
                                    <td class="text-center">{{ $withdraw->user->email }}</td>
                                    <td class="text-center">{{ $withdraw->user->full_name }}</td>
                                    <td class="text-center">{{ $withdraw->address }} 
									
									@if($withdraw->dest_tag)
										(Tag : {{$withdraw->dest_tag}})
									@endif
									</td>
                                    <td class="text-center">{{ $withdraw->coin->coin }}</td>
                                    <td class="text-right">{{ number_format($withdraw->amount, 8) }}</td>
                                    <td class="text-center" width="25%">
                                        @if($withdraw->status == 0)
                                            <button name="approve" class="btn btn-success btn-sm" title="Approve">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button name="reject" class="btn btn-danger btn-sm"  title="Reject">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                        @elseif($withdraw->status == 1)
                                            <span class="label label-success">Approved At</span> - {{ \Carbon\Carbon::parse($withdraw->updated_at)->toDateString() }}
                                        @elseif($withdraw->status == 2)
                                            Rejected With reason {{ $withdraw->remarks }}
                                        @elseif($withdraw->status == 3)
                                            Canceled At - {{ \Carbon\Carbon::parse($withdraw->updated_at)->toDateString() }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">{{trans('admin/approval/withdraw.No_Withdraw')}}</td>
                                </tr>
                            @endforelse
                                <tr> <td colspan="7" class="text-right">{{ $withdraws->links() }}</td> </tr>
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
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){

        $('.date-picker').datepicker({
            orientation: "bottom",
            autoclose: true
        });

        $('button[name=approve]').click(function () {
            var btnApprove = $(this);
            bootbox.confirm("Are you confirm to this withdrawal.", function(result){
                if(result) {
                    var code = btnApprove.closest('tr').data('id');
                    var data = {
                        _token: $('meta[name=csrf-token]').attr('content'),
                        transactionHash: result,
                        code: code
                    };

                    $.ajax({
                        url:"{{route('admin.withdraw.approve')}}",
                        type:'post',
                        data:data,
                        dataType:'json',
                        success: function (response) { //alert(response);
                            if(response.status) {
                                bootbox.alert(response.message);
                                location.reload();
                            } else {
                                bootbox.alert(response.message);
                            }
                            
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });
                } 
            });
        });

        $('button[name=reject]').click(function () {
            var btnReject = $(this);
            bootbox.prompt("Enter reason to decline withdraw request", function(result){
                if(result) {
                    var code = btnReject.closest('tr').data('id');

                    var data = {
                        _token: btnReject.attr('content'),
                        reason: result,
                        code:code
                    };

                    $.ajax({
                        url:"{{route('admin.withdraw.reject')}}",
                        type:'post',
                        data:data,
                        dataType:'json',
                        success: function (result) {
                            if(result.status) {
                                bootbox.alert(result.message);
                            } else {
                                bootbox.alert(result.message);
                            };
                            location.reload();
                        }
                    });
                } else {
                    bootbox.alert('We can\'t reject transaction without reason');
                }
            });
        });
    });
</script>
@endpush
