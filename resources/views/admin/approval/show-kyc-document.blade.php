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
    {{trans('admin/approval/withdraw.View')}}
    <small>{{trans('admin/approval/withdraw.Kyc_Document')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/approval/withdraw.Preview_Kyc_Document')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                    <div class="col-md-12">@include("flash::message")</div>
                        <div class="col-md-5">
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Identity_Card_No')}}:</th>
                                            <td>{{ $document->pan_card_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Address_Proof_Type')}}:</th>
                                            <td>{{ $document->address_proof }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Address_Proof_No')}}:</th>
                                            <td>{{ $document->address_proof_no }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.FirstName')}}:</th>
                                            <td>{{ $document->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.MiddleName')}}:</th>
                                            <td>{{ $document->middle_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.LastName')}}:</th>
                                            <td>{{ $document->last_name }}</td>
                                        </tr>                                    
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Date_of_Birth')}}:</th>
                                            <td>{{ $document->dob }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Address')}}:</th>
                                            <td>{!! nl2br($document->address) !!}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.State')}}:</th>
                                            <td>{{ $document->state }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Pin')}}:</th>
                                            <td>{{ $document->pin }}</td>
                                        </tr>
                                        @if($document->remarks)
                                        <tr>
                                            <th>{{trans('admin/approval/withdraw.Remarks')}}:</th>
                                            <td>{{ $document->remarks }}</td>
                                        </tr>
                                        @endif
                                        @if(!$document->status)
                                            <form method="post" action="{{ route('admin.kyc.process') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="document" value="{{ $document->code }}">
                                                <tr>
                                                    <th>
                                                        {{trans('admin/approval/withdraw.Remarks')}}
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control" name="remarks">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <button type="submit" class="btn btn-block btn-success" name="approve" value="true">{{trans('admin/approval/withdraw.Approve')}}</button>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-block btn-danger" name="reject" value="true">{{trans('admin/approval/withdraw.Reject')}}</button>
                                                    </td>
                                                </tr>
                                            </form>
                                        @else
                                        @if($document->remarks)
                                            <tr>
                                                <th>
                                                    {{trans('admin/approval/withdraw.Comments')}}:
                                                </th>
                                                <td class="text-danger">{{ $document->remarks }}</td>
                                            </tr>
                                        @endif 
                                            <tr>
                                                <th>
                                                    {{trans('admin/approval/withdraw.Status')}}:
                                                </th>
                                                <td class="text-{{['warning', 'success', 'danger'][ $document->status]}}">{{ ["Pending", "Approved", "Rejected"][ $document->status] }}</td>
                                            </tr> 
                                        @endif                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>                    
                        <div class="col-md-7">
                            <figure class="figure">
                                <img src="/storage/{{ $document->pan_doc }}" class="figure-img img-fluid" alt="identity card"  width="100%" height="236">
                                <figcaption class="figure-caption text-center">{{trans('admin/approval/withdraw.Identity_Card')}}</figcaption>
                            </figure><br>
                            <figure class="figure">
                                <img src="/storage/{{ $document->address_proof_doc_front }}" class="figure-img img-fluid" alt="address proof front"   width="100%" height="236">
                                <figcaption class="figure-caption text-center">{{trans('admin/approval/withdraw.Address_Proof_Front')}}</figcaption>
                            </figure><br>
                            <figure class="figure">
                                <img src="/storage/{{ $document->address_proof_doc_back }}" class="figure-img img-fluid" alt="address proof back"   width="100%" height="236">
                                <figcaption class="figure-caption text-center">{{trans('admin/approval/withdraw.Address_Proof_Back')}}</figcaption>
                            </figure>                                                    
                        </div>
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
