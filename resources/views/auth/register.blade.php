@extends('auth.layout')
@section('content')

<div class="login_section">
    <div class="container">
	<div class="alert_inner ">
			@include('flash::message')
		</div>
        <div class="login_container">
            <div class="row">
                <div class="col-md-6 col-sm-6 login_bg_01 login_padding">
                    <div class="login_height">
                        <a href="{{ route('home') }}"><img class="logo_login" src="{{ asset('/doch/img/logo02.png') }}" alt=""></a>
                       
                        <div class="form_height">
                           <form autocomplete="off" action="{{ route('register') }}" method="POST">
								{{ csrf_field() }}
								<input autocomplete="false" name="hidden" type="text" style="display:none;">
								
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<input id="email" type="email" class="login_input" name="email" value="{{ old('email') }}" placeholder="{{trans('auth/register.Enter_Your_Email')}}">
									@if ($errors->has('email'))
										<span class="text-danger">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									@endif
								</div>
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input id="password" type="password" class="login_input" name="password" placeholder="{{trans('auth/register.Your_password_here')}}">
									@if ($errors->has('password'))
										<span class="text-danger">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
								@php
								$display="style=display:none";
								if((\App\Setting::getFees('taker_fee') >0) && (\App\Setting::getFees('maker_fee') >0)){
								$display="";
								}
								@endphp
								<div {{$display}} class="form-group{{ $errors->has('referral_code') ? ' has-error' : '' }}">
									<input id="name" type="text" class="login_input" name="referral_code" value="{{ old('referral_code')?old('referral_code'):request('where-joining-code') }}" placeholder="{{trans('auth/register.Referral_Code')}}">
									@if ($errors->has('referral_code'))
										<span class="text-danger">
											<strong>{{ $errors->first('referral_code') }}</strong>
										</span>
									@endif
								</div>
								<div class="form-group text-center">
									{!! app('captcha')->display() !!}
									@if ($errors->has('g-recaptcha-response'))
										<span class="text-danger">
											<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
										</span>
									@endif
								</div>
								<div style="text-align: left;" class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}"> 
									<input id="i_accept" type="checkbox" class="check_box" name="terms">
									<label for="i_accept" class="check_label">{{trans('auth/register.I_accept_terms_conditions')}}  </label>
									@if ($errors->has('terms'))
										<span class="text-danger">
											<strong>{{ $errors->first('terms') }}</strong>
										</span>
									@endif
								</div>
								<div class="form-group">
									<button type="submit" class="register_btn btn-block">{{trans('auth/register.Register')}}</button>
								</div>

								
							</form>
                        </div>
                        <div class="sign_up_shadow"> {{trans('auth/register.Allready_have_an_account')}}<a href="{{ route('login') }}"> {{trans('auth/register.Login')}}</a></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 login_bg_02 login_padding">
                    <div class="login_height">
                        <a href="{{ route('home') }}"><img src="{{ asset('/doch/img/logo.png') }}" alt=""></a>
                        <p>{{trans('auth/register.Buy_Sell_and_Trade_Digital_Currencies_Tokens')}}</p>
					 </div>
					 <i class="fa fa-connectdevelop login_right_circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
