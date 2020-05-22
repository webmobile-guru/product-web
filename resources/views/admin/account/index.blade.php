@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/account/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/account/index.Manage_Account')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/account/index.Account')}}
    <small>{{trans('admin/account/index.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption"></div>
            </div>
            <div class="portlet-body flip-scroll">
                    <div class="row">
						<div class="col-md-1">Mode :</div>
						<div class="col-md-11">
							<div class="live_demo_btn btnloader" >
								@php $mode = session()->get('mode'); $mode = !($mode)?'live':$mode; @endphp
								<label>{{ strtoupper($mode) }} </label>

								<input class="state"  onchange="window.location='{!! route('admin.account.switch') !!}'" type="checkbox" data-on="Live" data-off="Demo" data-onstyle="success" data-offstyle="warning" data-toggle="toggle" data-size="large" {{($mode=="live")?"checked":""}}/>


							</div>
                        </div>
                    </div>
            </div>
        </div>              
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/account/index.User_Account_Management')}}</span>
                </div>
                <div class="inputs">
                    <div class="portlet-input input-inline input-medium">
                        <form method="get" action="{{ route('admin.account.index') }}">
                            <div class="input-group">
                                <input type="text" name="query" value="{{ request()->get('query') }}" class="form-control input-circle-left" placeholder="{{trans('admin/account/index.search')}}...">
                                <span class="input-group-btn">
                                    <button class="btn btn-circle-right btn-default" type="submit">{{trans('admin/account/index.Go')}}</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{trans('admin/account/index.Full_Name')}}</th>
                            <th>{{trans('admin/account/index.Email')}}</th>
                            {{--<th>Bitcoin</th>
                            <th>Zcash</th>
                            <th>Merrycoin</th>--}}
                            <th>{{trans('admin/account/index.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                {{--<td>{{ number_format($user->getBalance('BTC'), 8) }}</td>
                                <td>{{ number_format($user->getBalance('ZEC'), 8) }}</td>
                                <td>{{ number_format($user->getBalance('MCE'), 8) }}</td>--}}
                                <td>
									<a class="btn btn-warning" title="Show" data-url="{{ route('admin.account.show', $user->id) }}">{{trans('admin/account/index.Show_Balances')}}</a>
									<a class="btn btn-success" title="Credit" href="{{ route('admin.account.credit.get', $user->id) }}">{{trans('admin/account/index.Credit')}}</a>
									<a class="btn btn-danger" title="Debit"  href="{{ route('admin.account.debit.get', $user->id) }}">{{trans('admin/account/index.Debit')}}</a>
								</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="portlet-footer text-right">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog" class="modal" role="dialog"></div>
@include('admin.template.loader')

@endsection
@push('js')
<script>
    $(document).ready(function () {
        $('a[title=Show]').click(function(){
            var url = $(this).data('url'); 
            $.ajax({
                url: url,
                method: 'GET',
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) { 
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) { 
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });
    });
</script>
@endpush
