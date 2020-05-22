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
                <h2>{{trans('page/terms-conditions.TERMS_OF_SERVICE')}}</h2>
            </div>


            <div class="faq_inner">
                <h4>{{trans('page/terms-conditions.Terms_of_Service')}} </h4>
                <p>{{trans('page/terms-conditions.Modified_on')}}: 31 August, 2019 at 11AM</p>
            </div>
            <div class="faq_inner">
                <h4>{{trans('page/terms-conditions.h_1')}}</h4>
                <p>{{trans('page/terms-conditions.p_1')}}</p>
                <p>{{trans('page/terms-conditions.p_2')}}</p>
                <p>{{trans('page/terms-conditions.p_3')}}</p>
                <p>{{trans('page/terms-conditions.p_4')}}</p>
            </div>
            <div class="faq_inner">
                <h4>{{trans('page/terms-conditions.h_2')}}</h4>
                <p>{{trans('page/terms-conditions.p_5')}}</p>
                <p>{{trans('page/terms-conditions.p_6')}}</p>
                <p>{{trans('page/terms-conditions.p_7')}}</p>
                <p>{{trans('page/terms-conditions.p_8')}}</p>
                <p>{{trans('page/terms-conditions.p_9')}}</p>
            </div>
            <div class="faq_inner">
                <p>{{trans('page/terms-conditions.p_10')}}</p>
                <p>{{trans('page/terms-conditions.p_11')}}</p>
                <p>{{trans('page/terms-conditions.p_12')}}</p>
                <p>{{trans('page/terms-conditions.p_13')}}</p>
                <p>{{trans('page/terms-conditions.p_14')}}</p>
                <p>{{trans('page/terms-conditions.p_15')}}</p>
                <p>{{trans('page/terms-conditions.p_16')}}</p>
                <p>{{trans('page/terms-conditions.p_17')}}</p>
                <p>{{trans('page/terms-conditions.p_18')}}</p>
                <p>{{trans('page/terms-conditions.p_19')}}</p>
                <p>{{trans('page/terms-conditions.p_20')}}</p>
                <p>{{trans('page/terms-conditions.p_21')}}</p>
                <p>{{trans('page/terms-conditions.p_22')}}</p>
                <p>{{trans('page/terms-conditions.p_23')}}</p>
            </div>
            <div class="faq_inner">
                <h4>{{trans('page/terms-conditions.h_3')}}</h4>
                <p>{{trans('page/terms-conditions.p_24')}}</p>
                <p>{{trans('page/terms-conditions.p_25')}}</p>
                </div>
            <div class="faq_inner">
                <h4>{{trans('page/terms-conditions.p_26')}}</h4>
                <p>{{trans('page/terms-conditions.p_27')}}</p>
            </div>
            
        </div>
    </section>

@endsection
