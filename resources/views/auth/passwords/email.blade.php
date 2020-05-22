@extends('auth.layout')
@section('content')


{{--@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest--}}




<div class="login_section">
    <div class="container">
    <div class="alert_inner">
			@include('flash::message')
		</div>
        <div class="login_container">
            <div class="row">
                <div class="col-md-6 col-sm-6 login_bg_01 login_padding">
                    <div class="login_height">
                        <a href="{{ route('home') }}"><img class="logo_login" src="{{ asset('/doch/img/logo02.png') }}" alt=""></a>
                       
                        <div class="form_height">
                            <form autocomplete="off" method="POST" action="{{ route('password.email') }}">
								<input autocomplete="false" name="hidden" type="text" style="display:none;">
								{{ csrf_field() }}
								@if (session('status'))
									<div class="alert alert-success">
										{{ session('status') }}
									</div>
								@endif
								<div class="form-group">
									<input class="login_input" type="text" placeholder="{{trans('auth/passwords/email.Your_email_id_here')}}" name="email" value="{{ old('email') }}" required>
									@if ($errors->has('email'))
										<p class="error_para text-danger">{{ $errors->first('email') }}</p>
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
									<button class="register_btn btn-block" type="submit">{{trans('auth/passwords/email.Reset_Link')}}</button>
								</div>
								
							</form>
                        </div>
                        <div class="sign_up_shadow">{{trans('auth/passwords/email.Go_back_to')}}<a href="{{ route('login') }}"> {{trans('auth/passwords/email.Login')}}</a></div>
                     </div>
                </div>
                <div class="col-md-6 col-sm-6 login_bg_02 login_padding">
                    <div class="login_height">
                        <a href="{{ route('home') }}"><img src="{{ asset('/doch/img/logo.png') }}" alt=""></a>
                        <p>{{trans('auth/passwords/email.Please_enter_your_verified_email')}} </p>
					 </div>
					 <i class="fa fa-connectdevelop login_right_circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>










{{--@include('front.layout.footer')--}}

@endsection

