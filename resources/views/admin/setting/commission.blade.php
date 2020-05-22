@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">        
        <li>
            <span>{{trans('admin/setting/index.Dashboard')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/setting/index.Control')}}
    <small>{{trans('admin/setting/index.Panel')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">@include('flash::message')</div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('admin/setting/index.Apply_Commission_Settings')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ route('admin.setting.commission.post') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        {{--<div class="form-group">
                            <label>{{trans('admin/setting/index.Withdrawal_Commission')}}:</label>
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-dollar"></i>
                                        </span>
                                <input name="withdrawal_commission" value="{{$settings->where('key', 'withdrawal_commission')->isEmpty()?'':$settings->where('key', 'withdrawal_commission')->last()->value }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_Withdrawal_Commission')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{trans('admin/setting/index.Deposit_Fee')}}:</label>
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-dollar"></i>
                                        </span>
                                <input name="deposit_fee" value="{{$settings->where('key', 'deposit_fee')->isEmpty()?'':$settings->where('key', 'deposit_fee')->last()->value }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_Deposit_fee')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{trans('admin/setting/index.Transfer_Fee')}}:</label>
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-dollar"></i>
                                        </span>
                                <input name="transfer_fee" value="{{$settings->where('key', 'transfer_fee')->isEmpty()?'':$settings->where('key', 'transfer_fee')->last()->value }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_Transfer_fee')}}">
                            </div>
                        </div>--}}
                        <div class="form-group">
                            <label>{{trans('admin/setting/index.Taker_Fee')}}:</label>
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            %
                                        </span>
                                <input name="taker_fee" value="{{$settings->where('key', 'taker_fee')->isEmpty()?'':$settings->where('key', 'taker_fee')->last()->value }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_Taker_fee')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{trans('admin/setting/index.Maker_Fee')}}:</label>
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            %
                                        </span>
                                <input name="maker_fee" value="{{$settings->where('key', 'maker_fee')->isEmpty()?'':$settings->where('key', 'maker_fee')->last()->value }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_Maker_fee')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn blue">{{trans('admin/setting/index.Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('admin/setting/index.Apply_Referral_Settings')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ route('admin.setting.referral.post') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @php
                            $level = $settings->where('key', 'max_referral_level')->pluck('value')->first()
                        @endphp
                        <div class="form-group">
                            <label>{{trans('admin/setting/index.give_referral_commission')}}:</label>
                            <div class="input-group">
                                        <span class="input-group-addon">
                                            L
                                        </span>
                                <input
                                        name="max_referral_level"
                                        value="{{ $level }}"
                                        type="text"
                                        class="form-control"
                                        placeholder="{{trans('admin/setting/index.Enter_number_of_level')}}">
                            </div>
                        </div>

                        @for($i = 1; $i <= $level; $i++)
                            <div class="form-group">
                                <label>{{trans('admin/setting/index.level')}} {{ $i }}:</label>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            %
                                        </span>
                                    <input
                                            name="REFERRAL_LEVEL_{{ $i }}"
                                            value="{{ $settings->where('key', 'REFERRAL_LEVEL_'.$i)->pluck('value')->first() }}"
                                            type="text"
                                            class="form-control"
                                            placeholder="{{trans('admin/setting/index.Enter_number_of_level')}}">
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn blue">{{trans('admin/setting/index.Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function(){

        $('input[name=max_referral_level]').keyup(function(){
            var level = $(this).val();
            var element = '', i;
            var formGroup = $(this).closest('div.form-group');
            formGroup.nextAll().remove();
            for(i = 1; i <= level; i++) {
                element += '<div class="form-group">';
                element += '<label>Level '+ i + ':</label>';
                element += '<div class="input-group">';
                element += '<span class="input-group-addon">';
                element += '%';
                element += '</span>';
                element += '<input name="REFERRAL_LEVEL_'+i+'" value="" type="text" class="form-control" placeholder="Enter commission percent for level '+i+'">';
                element += '</div>';
                element += '</div>';
            }
            formGroup.after(element);
        });
    });
</script>
@endpush
