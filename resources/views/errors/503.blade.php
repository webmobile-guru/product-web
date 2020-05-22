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
		<h1>{{trans('errors/503.System_is_being_upgraded')}}</h1>
		<h3>{{trans('errors/503.We_will_be_back_after_sometimes')}}</h3>
		
	</div>
</div>





@endsection

