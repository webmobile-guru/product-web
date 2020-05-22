@extends('front.user')
@section('content')

    @guest
		@include('front.layout.guest-header')
	@else
		@include('front.layout.user-header')
	@endguest
   
<section class="all_padding">
    <div class="container">
        <div class="all_heading text-center">
            <h2>{{trans('page/about.h2_n_1')}}</h2>
        </div>

        <div class="faq_inner">
            <p>{{trans('page/about.p_1')}}</p>
        </div>
        <div class="faq_inner">
            <h4>{{trans('page/about.h4_n_1')}}</h4>
            <p>{{trans('page/about.p_2')}}</p>
            <p>{{trans('page/about.p_3')}}</p>
            <p>{{trans('page/about.p_4')}}</p>
            <p>{{trans('page/about.p_5')}}</p>
        </div>
        <div class="faq_inner">
            <h4>{{trans('page/about.h4_n_2')}}</h4>
            <p><strong>{{trans('page/about.p_6')}}</strong></p>
            <p><strong>{{trans('page/about.p_7')}}</strong></p>
            <p><strong>{{trans('page/about.p_8')}}</strong></p>
            <p><strong>{{trans('page/about.p_9')}}</strong></p>
            <p><strong>{{trans('page/about.p_10')}}</strong></p>
            <p><strong>{{trans('page/about.p_11')}}</strong></p>
            <p><strong>{{trans('page/about.p_12')}}</strong></p>
        </div>
        <div class="faq_inner">
            <h4>{{trans('page/about.h4_n_3')}}</h4>
            <p>{{trans('page/about.p_13')}}</p>
        </div>
        <div class="faq_inner">
            <h4>{{trans('page/about.h4_n_4')}}</h4>
        </div>
       
    </div>
</section>

        
           



@endsection
