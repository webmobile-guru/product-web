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
		<h1 class="error_text">{{trans('errors/403.Permission_denied')}}</h1>
		<h3>{{trans('errors/403.You_dont_have_permission')}}</h3>
		<a class="register_btn" href="{{ url('/') }}">{{trans('errors/403.Go_To_home')}}</a>
	</div>
</div>





@endsection

