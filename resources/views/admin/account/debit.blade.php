@extends('admin.layouts.master')
@section('page-bar')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('admin/account/debit.Home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('admin/account/debit.Manage_Account')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{trans('admin/account/debit.Account')}}
        <small>{{trans('admin/account/debit.Management')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/account/debit.Debit_Coins')}}</span>
                    </div>
                    {{--<div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
							<label class="btn btn-circle btn-transparent red-sunglo">
                                <input type="radio" name="options" class="toggle" id="option1">{{trans('admin/account/debit.BTC')}} {{ number_format($user->getBalance('BTC'), 8) }}</label>
                            <label class="btn btn-circle btn-transparent red-sunglo">
                                <input type="radio" name="options" class="toggle" id="option2">{{trans('admin/account/debit.ZEC')}} {{  number_format($user->getBalance('ZEC'), 8) }}</label>                           
							<label class="btn btn-circle btn-transparent red-sunglo">
                                <input type="radio" name="options" class="toggle" id="option2">{{trans('admin/account/debit.MCE')}} {{  number_format($user->getBalance('MCE'), 8) }}</label>
                        </div>
                    </div>--}}
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <div class="well">
                        @foreach($coins as $coin)
                            <label class="label label-primary"><strong>{{ $coin->coin }}</strong>:{{ number_format($user->getBalance($coin->coin), 8) }}</label>
                        @endforeach
                    </div>
                    <form method="post" class="form-horizontal" action="{{ route('admin.account.debit.post', $user->id) }}">
                        {{ csrf_field() }}
                        @foreach($coins as $coin)
                            <div class="form-group{{ $errors->has('coin.'.$coin->id)?' has-error':' has-feedback' }}">
                                <label for="" class="control-label col-md-3">{{ $coin->name }}</label>
                                <div class="col-md-9">
                                    <input
                                            autocomplete="off"
                                            placeholder="0.00000000"
                                            type="text"
                                            class="form-control"
                                            value="{{ old('coin.'.$coin->id) }}"
                                            name="coin[{{$coin->id}}]">
                                    @if($errors->has('coin.'.$coin->id))
                                        <span class="help-text">
                                            {{ $errors->first('coin.'.$coin->id) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group text-right">
                            <button type="reset " class="btn btn-submit">{{trans('admin/account/debit.Reset')}}</button>
                            <button type="submit" class="btn btn-submit">{{trans('admin/account/debit.Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script type="text/javascript">
    /*$(document).ready(function(){
        $('input[type=text]').keypress(function(event){
            if (event.which != 46 && (event.which < 47 || event.which > 59))
            {
                event.preventDefault();
                if ((event.which == 46) && ($(this).indexOf('.') != -1)) {
                    event.preventDefault();
                }
            }
        });
    });*/
</script>
@endpush
