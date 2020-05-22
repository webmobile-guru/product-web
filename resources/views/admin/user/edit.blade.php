
@inject('country', 'App\Country')
@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/user/edit.Modify_User')}}  @endsection
@section('dialogContent')
<div class="modal-body" style="overflow:hidden">
    <form id='modify-user' >
        <div class="col-md-6">
            <div class="form-group">
                <label for="first_name">{{trans('admin/user/edit.First_Name')}}:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ ucfirst($user->first_name) }}">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="country">{{trans('admin/user/edit.Country')}}:</label>            
                
                <select class="form-control" id="country" name="country" value="{{ $country->name }}">
                    <option value="">-- {{trans('admin/user/edit.Select_Country')}} --</option>
                    @foreach($country->all() as $country)        
                        <option value="{{ $country->id }}" {{ ($user->profile->country_id == $country->id)?'selected':'' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                <p class="help-block"></p>
            </div>        
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="last_name">{{trans('admin/user/edit.Last_Name')}}:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ ucfirst($user->last_name) }}">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="phone">{{trans('admin/user/edit.Phone')}}:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ ucfirst($user->profile->phone) }}">
                <p class="help-block"></p>
            </div>
        </div>
		
        <div class="col-md-12">
            <div class="form-group">
                <label for="short_name">{{trans('admin/user/edit.email')}}:</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                <p class="help-block"></p>
            </div>
        </div>
        @php
				$dob_date = explode(' ', $user->profile->dob);
				$dob = explode('-', $dob_date[0]);
		@endphp
		<div class="col-md-12">
			 <label>{{trans('front/user/profile.Date_of_Birth')}}</label>
			 <div class="row dob">
				<div class="col-md-4 col-sm-4">
					<input class="form-control" type="text" placeholder="MM" name="mm" value="{{ (isset($dob[1])?$dob[1]:'')}}">
				</div>
				<div class="col-md-4 col-sm-4">
					<input class="form-control" type="text" placeholder="DD" name="dd" value="{{ (isset($dob[2])?$dob[2]:'') }}">
				</div>
				<div class="col-md-4 col-sm-4">
					<input class="form-control" type="text" placeholder="YYYY" name="yy" value="{{ (isset($dob[0])?$dob[0]:'')}}" >
				</div>
				<p class="help-block"></p>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>{{trans('front/user/profile.Passport_Number')}}</label>
				<input class="form-control" type="text" value="{{ $user->profile->ide_no }}" name="ssn">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="photo col-md-12">
			<label>{{trans('front/user/profile.Image_of_Your_Passport')}}:</label>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<input type="file" id="ide_img" name="ide_img" accept="image/*">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					@if($user->profile->ide_proof_photo != '')
						<img class="no_pdf_img" src="{{ route('photo.get', [$user->profile->ide_proof_photo]) }}" alt="img" height="100">
					@else
						<img class="no_pdf_img" src="{{ asset('images/ide_image.png') }}" alt="img" height="100">
					@endif
				</div>
			</div>
			
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>{{trans('admin/user/edit.Passport_verify')}} :</label>
				
				<div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="passport_verify" value="0" {{ ($user->profile->ide_verify=='0')?'checked':'' }}> {{trans('admin/user/edit.Unverified')}}
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="passport_verify" value="1" {{ ($user->profile->ide_verify=='1')?'checked':'' }}> {{trans('admin/user/edit.Verified')}}
                        <span></span>
                    </label>                            
                </div>
				<p class="help-block"></p>
			</div>
		</div>
        <div class="col-md-6">
			<div class="form-group">
				<label>{{trans('front/user/profile.Street')}} </label>
				<input class="form-control" name="address" type="text" value="{{ $user->profile->address }}">
				<p class="help-block"></p>
			</div>
			<div class="form-group">
				<label>{{trans('front/user/profile.State')}}</label>
				<input class="form-control" type="text" name="state" value="{{ $user->profile->state }}">
				<p class="help-block"></p>
			</div>
			
		
            <div class="form-group">
                <label for="password">{{trans('admin/user/edit.Password')}}:</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label>{{trans('admin/user/edit.Role')}}:</label>
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="role" value="admin" {{ ($user->profile->role=='admin')?'checked':'' }}> {{trans('admin/user/edit.Admin')}}
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="role" value="subscriber" {{ ($user->profile->role=='subscriber')?'checked':'' }}> {{trans('admin/user/edit.Subscriber')}}
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
        </div>
        
        <div class="col-md-6">
			<div class="form-group">
				<label>{{trans('front/user/profile.City')}}</label>
				<input class="form-control" type="text" name="city" value="{{ $user->profile->city }}">
				<p class="help-block"></p>
			</div>
			<div class="form-group">
				<label>{{trans('front/user/profile.postal')}}</label>
				<input class="form-control" type="text" value="{{ $user->profile->zip }}" name="zip">
				<p class="help-block"></p>
			</div>
            <div class="form-group">
                <label for="password_confirmation">{{trans('admin/user/edit.Confirm_Password')}}:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                <p class="help-block"></p>
            </div>
            
            <div class="form-group">
                <label>{{trans('admin/user/edit.Status')}}:</label>
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="status" value="1" {{ ($user->profile->status=='1')?'checked':'' }}>{{trans('admin/user/edit.Active')}} 
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="status" value="0" {{ ($user->profile->status=='0')?'checked':'' }}>{{trans('admin/user/edit.Inactive')}} 
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
			
            <div class="form-group">
                <label>Auto Withdraw:</label>
                <div class="mt-radio-inline">
                    <label class="mt-radio">
                        <input type="radio" name="withdraw_enable_auto" value="1" {{ ($user->profile->withdraw_enable_auto=='1')?'checked':'' }}>{{trans('admin/user/edit.Active')}} 
                        <span></span>
                    </label>
                    <label class="mt-radio">
                        <input type="radio" name="withdraw_enable_auto" value="0" {{ ($user->profile->withdraw_enable_auto=='0')?'checked':'' }}>{{trans('admin/user/edit.Inactive')}} 
                        <span></span>
                    </label>                            
                </div>
                <p class="help-block"></p>
            </div>
        </div>               
    </form>
</div>
<div class="col-md-12">
<p class="above_error" style="color: #e73d4a;"></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/user/edit.Close')}}</button>
    <button type="button" class="btn green" onclick="saveUser('admin/user/{{ $user->id }}', $('form[id=modify-user]'), true)">{{trans('admin/user/edit.Save_changes')}}</button>
</div>
@stop    
