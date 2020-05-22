@extends('front.user')
@section('content')
<style>
footer{display:none;}
</style>

@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest

<body class="error_section">

<div class="error_color">
	<div class="container">
		<h1 class="error_text">{{trans('errors/expired.Session_Expired')}}</h1>
		<h3>{{trans('errors/expired.Your_session_has_been_expired')}}</h3>
		<a class="register_btn" href="{{ url('/') }}">{{trans('errors/expired.Go_To_home')}}</a>
	</div>
</div>





@endsection
