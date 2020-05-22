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
        <div class="col-md-12">
            @include('flash::message')
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">{{trans('admin/setting/index.Apply_Settings')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form role="form" action="{{ route('admin.setting.coins.post') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-body">
                                <div class="form-group{{ $errors->has('coin')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.apply_setting_for')}}:</label>
                                    <select name="coin" class="form-control">
                                        @foreach($coins as $coin)
                                            <option
                                                    {{  (old('coin') == $coin->id)?'selected':'' }}
                                                    value="{{ $coin->id }}"
                                                    data-url="{{ route('admin.setting.coins.display', [$coin->id]) }}">{{ $coin->name }}({{ $coin->coin }})</option>
                                        @endforeach
                                    </select>
                                    <p class="help-block">{{ $errors->first('coin') }}</p>
                                </div>

                                <div class="form-group{{ $errors->has('deposit_status')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Deposit_Status')}}:</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="deposit_status"  value="disable" {{ ((old('deposit_status') == 'disable') or (!$deposit_enabled))?'checked':'' }}> {{trans("admin/setting/index.Disable")}}
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="deposit_status" value="enable" {{ ((old('deposit_status') == 'enable') or ($deposit_enabled))?'checked':'' }}> {{trans("admin/setting/index.Enable")}}
                                            <span></span>
                                        </label>
                                    </div>
                                    <p class="help-block">{{ $errors->first('deposit_status') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('deposit_fee')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Deposit_Fee')}}:</label>
                                    <input name="deposit_fee" value="{{ old('deposit_fee')?:$deposit_fees }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_deposit_fee_in_flat_amount')}}">
                                    <p class="help-block">{{ $errors->first('deposit_fee') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('min_deposit_amount')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Minimum_Deposit_Amount')}}:</label>
                                    <input name="min_deposit_amount" value="{{ old('min_deposit_amount')?:$deposit_min_amount }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_minimum_deposit_amount')}}">
                                    <p class="help-block">{{ $errors->first('min_deposit_amount') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('max_deposit_amount')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Maximum_Deposit_Amount')}}:</label>
                                    <input name="max_deposit_amount" value="{{ old('max_deposit_amount')?:$deposit_max_amount }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_maximum_deposit_amount')}}">
                                    <p class="help-block">{{ $errors->first('max_deposit_amount') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('withdraw_status')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Withdraw_Status')}}:</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="withdraw_status"  value="disable" {{ ((old('withdraw_status') == 'disable') or (!$withdraw_enabled))?'checked':'' }}> {{trans("admin/setting/index.Disable")}}
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="withdraw_status" value="enable" {{ ((old('withdraw_status') == 'enable') or ($withdraw_enabled))?'checked':'' }}> {{trans("admin/setting/index.Enable")}}
                                            <span></span>
                                        </label>
                                    </div>
                                    <p class="help-block">{{ $errors->first('withdraw_status') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('withdraw_fee')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Withdraw_Fee')}}:<strong>(%)</strong></label>
                                    <input name="withdraw_fee" value="{{ old('withdraw_fee')?:$withdraw_fees }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_withdraw_fee_in_flat_amount')}}">
                                    <p class="help-block">{{ $errors->first('withdraw_fee') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('min_withdraw_amount')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Minimum_Withdraw_Amount')}}:</label>
                                    <input name="min_withdraw_amount" value="{{ old('min_withdraw_amount')?:$withdraw_min_amount }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_minimum_withdraw_amount')}}">
                                    <p class="help-block">{{ $errors->first('min_withdraw_amount') }}</p>
                                </div>
                                <div class="form-group{{ $errors->has('max_withdraw_amount')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Maximum_Withdraw_Amount')}}:</label>
                                    <input name="max_withdraw_amount" value="{{ old('max_withdraw_amount')?:$withdraw_max_amount }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.Enter_maximum_withdraw_amount')}}">
                                    <p class="help-block">{{ $errors->first('max_withdraw_amount') }}</p>
                                </div>
                              
                                <div style="display: none" class="form-group{{ $errors->has('auto_withdraw_after')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.Set_Maximum_Withdraw_Amount')}}:</label>
                                    <input name="auto_withdraw_after" value="{{ old('auto_withdraw_after')?:$auto_withdraw_after }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.auto_withdraw_after')}}">
                                    <p class="help-block">{{ $errors->first('auto_withdraw_after') }}</p>
                                </div>
                                <div style="display: none" class="form-group{{ $errors->has('auto_withdraw_address')?' has-error':' has-feedback' }}">
                                    <label>{{trans('admin/setting/index.auto_withdraw_address')}}:</label>
                                    <input name="auto_withdraw_address" value="{{ old('auto_withdraw_address')?:$auto_withdraw_address }}" type="text" class="form-control" placeholder="{{trans('admin/setting/index.auto_withdraw_address')}}">
                                    <p class="help-block">{{ $errors->first('auto_withdraw_address') }}</p>
                                </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn blue">{{trans('admin/setting/index.Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.template.loader')
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name=coin]').change(function(){
            var selected = $(this).find('option:selected').val();
            var url = $(this).find('option:selected').data('url');
            $.ajax({
                type:'get',
                url:url,
                dataType:'json',
                beforeSend:function(){
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success:function(result){

                    $('input:radio[name="deposit_status"]:nth('+ Number(result.deposit_enabled) +')')
                            .prop('checked',true);

                    $('input[name="deposit_fee"]').val(result.deposit_fees);
                    $('input[name="min_deposit_amount"]').val(result.deposit_min_amount);
                    $('input[name="max_deposit_amount"]').val(result.deposit_max_amount);

                    $('input:radio[name="withdraw_status"]:nth('+ Number(result.withdraw_enabled) +')')
                            .prop('checked',true);

                    $('input[name="withdraw_fee"]').val(result.withdraw_fees);
                    $('input[name="min_withdraw_amount"]').val(result.withdraw_min_amount); 
                    $('input[name="max_withdraw_amount"]').val(result.withdraw_max_amount);
                    $('input[name="auto_withdraw_address"]').val(result.auto_withdraw_address);
                    $('input[name="auto_withdraw_after"]').val(result.auto_withdraw_after); 
                    $('div[id=myLoader]').modal('hide');
                },
                error:function(result){
                    console.log(result);
                    $('div[id=myLoader]').modal('hide');
                }
            })
        });
    });
</script>
@endpush
