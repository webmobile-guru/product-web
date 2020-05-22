@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/coin/create.Create_Coin')}} @endsection
@section('dialogContent')
<div class="modal-body">
    <form id='create-coin'>
        <div class="form-group">
            <label for="coin_name">{{trans('admin/coin/create.Coin_Name')}}:</label>
            <input type="text" class="form-control" id="coin_abbr" name="coin_name">
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label for="short_name">{{trans('admin/coin/create.Short_Name')}}:</label>
            <input type="text" class="form-control" id="short_name" name="short_name">
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin/create.Is_Base_Coin')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="base_info" value="1"> {{trans('admin/coin/create.Yes')}}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="base_info"  value="0"> {{trans('admin/coin/create.No')}}
                    <span></span>
                </label>
            </div>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin/create.Coin_Type')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="coin_type" value="Crypto"> {{trans('admin/coin/create.Crypto')}}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="coin_type"  value="Fiat"> {{trans('admin/coin/create.Fiat')}}
                    <span></span>
                </label>
            </div>
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label>{{trans('admin/coin/create.Withdraw_Method')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="withdraw_m" value="automatic"> {{trans('admin/coin/create.Automatic')}}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="withdraw_m"  value="manual"> {{trans('admin/coin/create.Manual')}}
                    <span></span>
                </label>
            </div>
            <p class="help-block"></p>
        </div>

        <div class="form-group">
            <label>{{trans('admin/coin/create.Status')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="status" value="1"> {{trans('admin/coin/create.Active')}}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="status" value="0"> {{trans('admin/coin/create.Inactive')}}
                    <span></span>
                </label>
            </div>
            <p class="help-block"></p>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/coin/create.Close')}}</button>
    <button type="button" class="btn green" onclick="saveCoinPair('admin/coin', $('form[id=create-coin]'))">{{trans('admin/coin/create.Save_changes')}}</button>
</div>
@stop
