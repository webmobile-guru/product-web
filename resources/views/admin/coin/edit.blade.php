@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/coin/edit.Modify_Coin')}} @endsection
@section('dialogContent')
<div class="modal-body">
    <form id="modify-coin">
        <div class="form-group">
            <label for="coin_name">{{trans('admin/coin/edit.Coin_Name')}}:</label>
            <input type="text" class="form-control" id="coin_abbr" name="coin_name" value="{{ $coin->name }}">
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label for="short_name">{{trans('admin/coin/edit.Short_Name')}}:</label>
            <input type="text" class="form-control" id="short_name" name="short_name" value="{{ $coin->coin }}">
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin/edit.Is_Base_Coin')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="base_info" value="1" @if($coin->is_base==1) checked @endif>{{trans('admin/coin/edit.Yes')}} 
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="base_info"  value="0"  @if(!($coin->is_base==1)) checked @endif>{{trans('admin/coin/edit.No')}} 
                    <span></span>
                </label>                            
            </div>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin/edit.Coin_Type')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="coin_type" value="Crypto" @if($coin->currency_type =='Crypto') checked @endif> {{trans('admin/coin/edit.Crypto')}}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="coin_type"  value="Fiat" @if($coin->currency_type =='Fiat') checked @endif> {{trans('admin/coin/edit.Fiat')}}
                    <span></span>
                </label>
            </div>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin/edit.Withdraw_Method')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="withdraw_m" value="automatic" @if($coin->withdraw =='automatic') checked @endif>{{trans('admin/coin/edit.Automatic')}} 
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="withdraw_m"  value="manual" @if($coin->withdraw =='manual') checked @endif>{{trans('admin/coin/edit.Manual')}} 
                    <span></span>
                </label>
            </div>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin/edit.Status')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="status" value="1" @if($coin->status==1 ) checked @endif>{{trans('admin/coin/edit.Active')}} 
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="status" value="0" @if(!($coin->status==1)) checked @endif>{{trans('admin/coin/edit.Inactive')}} 
                    <span></span>
                </label>                            
            </div>
            <p class="help-block"></p>
        </div>           
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/coin/edit.Close')}}</button>
    <button type="button" class="btn green" onclick="saveCoinPair('admin/coin/{{ $coin->id }}', $('form[id=modify-coin]'), true)">{{trans('admin/coin/edit.Save_changes')}}</button>
</div>
@stop

