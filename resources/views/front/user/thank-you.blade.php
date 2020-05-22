@extends('auth.layout')
@section('content')

<div class="login_section">
    <div class="login_circle"></div>
    <div class="container">
        <div class="login_container">
            <div class="row">
                
                <div class="col-md-12 col-sm-12 login_bg_01  login_padding" style="color: #000;">
                    <div class="login_height">
                        <div class="login_height">
							<h1>{{trans('front/user/thank-you.Registration')}}</h1>
							<a href="{{ route('home') }}"><img src="{{ asset('/doch/img/logo02.png') }}" alt=""></a>
						   
							<div class="form_height">
								<p class="text-left">
									{{trans('front/user/thank-you.Registration_Completed')}}
								</p>

								<p class="text-left">
									{{trans('front/user/thank-you.Thank_you_for_signing_up')}}
								</p>
								<p class="text-left">
									{{trans('front/user/thank-you.Thanks')}}
								</p>
								<p class="text-left">
									{{trans('front/user/thank-you.Teambtc')}}
								</p>
							</div>
							<div class="sign_up_shadow"> {{trans('front/user/thank-you.Go_to_my_account')}} <a href="{{ url('login') }}"> {{trans('front/user/thank-you.Login')}}</a></div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
