@inject('country', 'App\Country')
@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/user/create.Create_User')}} @endsection
@section('dialogContent')
<div class="modal-body" style="overflow:hidden">
    <form id='create-user'>
        <div class="col-md-6">
            <div class="form-group">
                <label for="first_name">{{trans('admin/user/create.First_Name')}}:</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="country">{{trans('admin/user/create.Country')}}:</label>
                <select class="form-control" id="country" name="country" value="{{ $country->name }}">
                    <option value="">-- {{trans('admin/user/create.Select_Country')}} --</option>
                    @foreach($country->all() as $country)        
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                <p class="help-block"></p>
            </div>        
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="last_name">{{trans('admin/user/create.Last_Name')}}:</label>
                <input type="text" class="form-control" id="last_name" name="last_name">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="phone">{{trans('admin/user/create.Phone')}}:</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="short_name">{{trans('admin/user/create.email')}}:</label>
                <input type="text" class="form-control" id="email" name="email">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password">{{trans('admin/user/create.Password')}}:</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label>{{trans('admin/user/create.Role')}}:</label>
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="role" value="admin">{{trans('admin/user/create.Admin')}} 
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="role" value="subscriber">{{trans('admin/user/create.Subscriber')}} 
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password_confirmation">{{trans('admin/user/create.Confirm_Password')}}:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label>{{trans('admin/user/create.Status')}}:</label>
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="status" value="1">{{trans('admin/user/create.Active')}} 
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="status" value="0">{{trans('admin/user/create.Deactive')}} 
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
        </div>               
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/user/create.Close')}}</button>
    <button type="button" class="btn green" onclick="saveUser('admin/user', $('form[id=create-user]'))">{{trans('admin/user/create.Save_changes')}}</button>
</div>
@stop    
