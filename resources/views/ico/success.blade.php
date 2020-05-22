@extends('front.user')
@section('content')
@guest
    @include('front.layout.guest-header')
@else
    @include('front.layout.user-header')
@endguest
    <section class="sm_padding">
		<div class="container">
			<div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
				<strong>{{trans('ico/success.Congratulation')}}</strong> {{trans('ico/success.ico_has_been_submited')}}
			</div>
		</div>
        
    </section>
@endsection
