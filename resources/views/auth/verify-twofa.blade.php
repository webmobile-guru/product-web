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
                         <a href="{{ route('home') }}"><img class="logo_login" src="{{ asset('/doch/img/logo02.png?fgbhd') }}" alt=""></a>
                       
                        <div class="form_height">
                            <form method="POST" action="{{ route('security.2fa.post') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input class="user_section login_input" type="text" placeholder="{{trans('auth/verify-twofa.Enter_Your_2FA_code_here')}}" name="code" required>
                                    @if ($errors->has('code'))
                                        <span class="text-danger">{{ $errors->first('code') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button class="register_btn btn-block" type="submit">{{trans('auth/verify-twofa.Verify')}}</button>
                                </div>
                            </form>
                            <div class="sign_up_shadow"><a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> {{trans('auth/verify-twofa.Logout')}}</a></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="post">
                                {{ csrf_field() }}
                            </form>
                        </div>
                     </div>
                </div>
                <div class="col-md-6 col-sm-6 login_bg_02 login_padding">
                    <div class="login_height">
                        <a href="{{ route('home') }}"><img src="{{ asset('/doch/img/logo.png') }}" alt=""></a>
                        <p>{{trans('auth/verify-twofa.For_an_extra_layer_of_account_security')}}</p>
                    </div>
                    <i class="fa fa-connectdevelop login_right_circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>






@endsection
