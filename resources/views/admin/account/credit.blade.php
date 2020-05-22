@extends('admin.layouts.master')
@section('page-bar')
    {{--@php $common = new  \App\Libs\Common; @endphp--}}
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('admin/account/credit.Home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('admin/account/credit.Manage_Account')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{trans('admin/account/credit.Account')}}
        <small>{{trans('admin/account/credit.Management')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/account/credit.Credit_Coins')}}</span>
                    </div>
                    {{--<div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn btn-circle btn-transparent red-sunglo">
                                <input type="radio" name="options" class="toggle" id="option1">{{trans('admin/account/credit.BTC')}} {{ number_format($user->getBalance('BTC'), 8) }}</label>
                            <label class="btn btn-circle btn-transparent red-sunglo">
                                <input type="radio" name="options" class="toggle" id="option2">{{trans('admin/account/credit.ZEC')}} {{  number_format($user->getBalance('ZEC'), 8) }}</label>
                            <label class="btn btn-circle btn-transparent red-sunglo">
                                <input type="radio" name="options" class="toggle" id="option2">{{trans('admin/account/credit.MCE')}} {{  number_format($user->getBalance('MCE'), 8) }}</label>
                        </div>
                    </div>--}}
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <div class="well">
                        @foreach($coins as $coin)
                            <label class="label label-primary"><strong>{{ $coin->coin }}</strong>:{{ number_format($user->getBalance($coin->coin), 3) }}</label>
                        @endforeach
                    </div>
                    <form method="post" class="form-horizontal" action="{{ route('admin.account.credit.post', $user->id) }}">
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
                            <button type="reset " class="btn btn-submit">{{trans('admin/account/credit.Reset')}}</button>
                            <button type="submit" class="btn btn-submit">{{trans('admin/account/credit.Submit')}}</button>
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

