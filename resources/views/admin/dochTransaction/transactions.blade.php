@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/coin/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Doch Transactions</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    Doch Transactions
    {{-- <small>{{trans('admin/coin/index.Master_Management')}}</small> --}}
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
                    <span class="caption-subject font-red sbold uppercase">Doch Transactions Management</span>
                </div>
                
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    @include('flash::message')
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th> {{trans('admin/coin/index.ID')}} </th>
                                <th> Name </th>
                                <th> Address </th>
                                <th> Transaction Hash </th>
                                <th> Amount </th>
                                <td> Status</td>
                                <th> Added On</th>
                                <th style="width:20%" class="text-center"> {{trans('admin/coin/index.Action')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td> {{ $transaction->id }} </td>
                                    @php 

                                        if($transaction->status==0){
                                            $stat_text ="Pending";
                                        }elseif($transaction->status==1){
                                            $stat_text ="Approved";
                                        }elseif($transaction->status==2){
                                            $stat_text ="Denied";
                                        }
                                        $user =  $transaction->user; 
                                    @endphp
                                    <td>{{ $user->first_name." ".$user->last_name }}</td>
                                     <td>{{ $transaction->address }}</td>
                                     <td>{{ $transaction->transaction_hash }}</td>
                                     <td>{{ $transaction->amount }}</td>
                                     <td>{{ $stat_text }}</td>
                                     <td>{{ $transaction->created_at }}</td>
                                    <td style="width:20%" class="text-center">
                                        @if($transaction->status==0)
                                        <button name="approve" type="button" data-id="{{ $transaction->id }}" class="btn btn-outline btn-circle btn-sm purple">
                                            <a href="{{ route('admin.dochTransaction.approveStatus',$transaction->id) }}"> Approve </a>
                                        </button>
                                        <button name="cancel" type="button" data-id="{{ $transaction->id }}" class="btn btn-outline btn-circle btn-sm red">
                                            <a href="{{ route('admin.dochTransaction.denyStatus',$transaction->id) }}"> Deny </a>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> {{trans('admin/coin/index.exists')}} </td>
                                </tr>
                            @endforelse
                                <tr>
                                    <td colspan="6" class="text-right">{{ $transactions->links() }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog" class="modal" role="dialog"></div>

@include('admin.template.loader')

@endsection
@push('js')

@endpush

