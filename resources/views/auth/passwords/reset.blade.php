@extends('auth.layout')
@section('content')


{{--@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest--}}


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
                            <form method="POST" autocomplete="off"  action="{{ route('password.request') }}">
								<input autocomplete="false" name="hidden" type="text" style="display:none;">
								{{ csrf_field() }}

								<input type="hidden" name="token" value="{{ $token }}">

								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

									<input id="email" type="email" class="login_input" name="email" value="{{ $email or old('email') }}" placeholder="{{trans('auth/passwords/reset.EmailId')}}" required autofocus>

									@if ($errors->has('email'))
										<span class="text-danger">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>

								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									
									<input id="password" type="password" class="login_input" name="password" placeholder="{{trans('auth/passwords/reset.Password')}}" required>

									@if ($errors->has('password'))
										<span class="text-danger">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>

								<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									
									<input id="password-confirm" type="password" class="login_input" name="password_confirmation" placeholder="{{trans('auth/passwords/reset.Confirm_Password')}}" required>

									@if ($errors->has('password_confirmation'))
										<span class="text-danger">
											<strong>{{ $errors->first('password_confirmation') }}</strong>
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
								<div class="form-group">
									<button type="submit" class="register_btn btn-block">{{trans('auth/passwords/reset.Reset_Password')}}</button>
								</div>
								
							</form>
                        </div>
                        <div class="sign_up_shadow">{{trans('auth/passwords/reset.Go_back_to')}}<a href="{{ route('login') }}">{{trans('auth/passwords/reset.Login')}}</a></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 login_bg_02 login_padding">
                    <div class="login_height">
                         <a href="{{ route('home') }}"><img src="{{ asset('/doch/img/logo.png') }}" alt=""></a>
                        <p>{{trans('auth/passwords/reset.Please_provide_the_email_address')}}</p>
					 </div>
					 <i class="fa fa-connectdevelop login_right_circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>





{{--@include('front.layout.footer')--}}

@endsection

