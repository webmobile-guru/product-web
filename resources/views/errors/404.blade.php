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
		<h1 class="error_text">{{trans('errors/404.404')}}</h1>
		<h3>{{trans('errors/404.Page_Not_Found')}}</h3>
		<a class="register_btn" href="{{ url('/') }}">{{trans('errors/404.Go_To_home')}}</a>
	</div>
</div>





@endsection
