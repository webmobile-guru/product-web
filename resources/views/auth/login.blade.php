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
                        
                        <a href="{{ route('home') }}"><img class="logo_login" src="{{ asset('/doch/img/logo02.png?dfc') }}" alt=""></a>
                       
                        <div class="form_height">
								
							   <form role="form"  autocomplete="off" method="POST" action="{{ route('login') }}">
								<input autocomplete="false" name="hidden" type="text" style="display:none;">
								{{ csrf_field() }}
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

									<input id="email" type="email" placeholder="{{trans('auth/login.Enter_Your_Email')}}" class="login_input" name="email" value="{{ old('email') }}" autofocus>
									@if ($errors->has('email'))
										<span class="text-danger">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>

								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input id="password" type="password" placeholder="{{trans('auth/login.Enter_Your_Password')}}" class="login_input" name="password">
									@if ($errors->has('password'))
										<span class="text-danger">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
								</div>
								
									
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-4">
											<img src="<?php echo $builder->inline(); ?>" />
										</div>
										<div class="col-md-8 col-sm-8 col-8">
											<input  type="text" name="captcha" class="login_input" placeholder="{{trans('auth/login.Enter_what_you_see')}}">
											@if ($errors->has('captcha'))
												<span class="text-danger">
													<strong>{{ $errors->first('captcha') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
							    <div class="form-group">
									<button type="submit" class="register_btn btn-block">{{trans('auth/login.Login')}}</button>
							   </div>
							</form>
                        </div>
                        <div class="sign_up_shadow">{{trans('auth/login.Dont_have_an_account')}}<a href="{{ route('register') }}"> {{trans('auth/login.Sign_Up_Now')}}</a></div>
                        <a class="forgot_link" href="{{ route('password.request') }}">{{trans('auth/login.Forgot_Password')}}</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 login_bg_02 login_padding">
                    <div class="login_height">
                        <a href="{{ route('home') }}"><img src="{{ asset('/doch/img/logo.png?df') }}" alt=""></a>
                        <p>{{trans('auth/login.Please_enter_your_verified_email')}} </p>
					</div>
					<i class="fa fa-connectdevelop login_right_circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>






{{--@include('front.layout.footer')--}}
<!--login section end-->
@endsection

