@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/coin-pair/create.Create_Coin')}} @endsection
@section('dialogContent')
<div class="modal-body">
    <form id='modify-coin-pair'>
        <div class="form-group">
            <label for="pair_name">{{trans('admin/coin-pair/edit.Coin_Pair_Name')}}:</label>
            <input type="text" class="form-control" id="pair_name" name="pair_name" value="{{ $coinpair->pair_name }}">
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label for="base_coin">{{trans('admin/coin-pair/edit.Base_Coin')}}:</label>
            <select class="form-control" id="base_coin" name="base_coin">
                @foreach($base as $key => $value)
                    <option value="{{ $key }}" {{ ($key == $coinpair->base_coin_id)?'Selected':'' }}>{{ $value }}</option>
                @endforeach
            </select>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label for="secondary_coin">{{trans('admin/coin-pair/edit.Secondary_Coin')}}:</label>
            <select class="form-control" id="secondary_coin" name="secondary_coin">
                @foreach($others as $key => $value)
                    <option value="{{ $key }}" {{ ($key == $coinpair->coin_id)?'Selected':'' }}>{{ $value }}</option>
                @endforeach
            </select>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <label>{{trans('admin/coin-pair/edit.Status')}}:</label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input type="radio" name="status" value="1" {{($coinpair->status)?'checked':''}}>{{trans('admin/coin-pair/edit.Active')}} 
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input type="radio" name="status" value="0" {{(!($coinpair->status))?'checked':''}}>{{trans('admin/coin-pair/edit.Inactive')}} 
                    <span></span>
                </label>                            
            </div>
            <p class="help-block"></p>
        </div>           
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/coin-pair/edit.Close')}}</button>
    <button type="button" class="btn green" onclick="saveCoin('admin/coin-pair/{{ $coinpair->id }}', $('form[id=modify-coin-pair]'), true)">{{trans('admin/coin-pair/edit.Save_changes')}}</button>
</div>
@stop
