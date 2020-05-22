@extends('admin.layouts.master')
@section('page-bar')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('admin/coin/request/index.Home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('admin/coin/request/index.Manage_Coin_List')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{trans('admin/coin/request/index.Coin_List')}}
        <small>{{trans('admin/coin/request/index.Master_Management')}}</small>
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
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/coin/request/index.Coin_List_Master_Management')}}</span>
                </div>
                {{--<div class="actions">
                    <button class="btn red btn-outline sbold" name="create"> {{trans('admin/coin/request/index.Add_Coin')}}</button>
                </div>--}}
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                        <tr>
                            <th> {{trans('admin/coin/index.ID')}} </th>
                            <th> {{trans('admin/coin/index.Name')}} </th>
                            <th> {{trans('admin/coin/index.Short_Name')}} </th>
                            {{--<th> Config Detail </th>--}}
                            <th> {{trans('admin/coin/request/index.Contacts')}}</th>
                            <th> {{trans('admin/coin/index.Status')}} </th>
                            <th style="width:20%" class="text-center"> {{ trans('admin/coin/index.Action') }} </th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($coinsForList as $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td>{{ ucfirst($list->coin_name) }}</td>
                                    <td>{{ $list->coin_symbol }}</td>
                                    <td>
                                        <a title="link to coin site" class="btn btn-xs btn-info" href="{{ $list->website_link }}" target="_blank"><i class="fa fa-globe"></i></a>
                                        <a title="link to whitepaper" class="btn btn-xs btn-info" href="{{ $list->whitepaper_link }}" target="_blank"><i class="fa fa-file"></i></a>
                                        <a title="mail to authority" class="btn btn-xs btn-warning" href="mailto:{{ $list->contact_email }}" target="_top"><i class="fa fa-envelope"></i></a>
                                    </td>
                                    <td><span class="text-{{ ['info', 'success'][$list->status] }}">{{ ['Pending', 'Approved'][$list->status] }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.coin.request.show', $list->id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
                                        @if($list->status == 0)
                                            <a data-href="{{ route('admin.coin.request.approve', $list->id) }}" title="approve" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                                            <a data-href="{{ route('admin.coin.request.reject', $list->id) }}" title="reject" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="text-center text-danger">{{trans('admin/coin/request/index.Data_doesnot_exists')}}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('a[title=approve]').click(function () {
            var url = $(this).data('href');
            bootbox.confirm('Are you sure you want to approve this coin for listing?', function(result){
                if(result){
                    $.ajax({
                        type:'post',
                        url:url,
                        dataType:'json',
                        success:function(result){
                            if(result.status) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        });

        $('a[title=reject]').click(function () {
            var url = $(this).data('href');
            bootbox.confirm('Are you sure you want to reject this coin from listing?', function(result){
                if(result){
                    $.ajax({
                        type:'post',
                        url:url,
                        dataType:'json',
                        success:function(result){
                            if(result.status) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

