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
                <h2>{{trans('page/privacy-policy.PRIVACY_POLICY')}}</h2>
            </div>
                
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_1')}}</h4>
                    <p>{{trans('page/privacy-policy.p_1')}}</p>
                    <p>{{trans('page/privacy-policy.p_2')}}</p>
                    <p>{{trans('page/privacy-policy.p_3')}}</p>
                </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_2')}}</h4>
                    <p>{{trans('page/privacy-policy.p_4')}}</p>
                 </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_3')}}</h4>
                    <p>{{trans('page/privacy-policy.p_5')}}</p>
                    <p>{{trans('page/privacy-policy.p_6')}}</p>
                    <p>{{trans('page/privacy-policy.p_7')}}</p>
                    <p>{{trans('page/privacy-policy.p_8')}}</p>
                    <p>{{trans('page/privacy-policy.p_9')}}</p>
                 </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_4')}}</h4>
                    <p>{{trans('page/privacy-policy.p_10')}}</p>
                    <p>{{trans('page/privacy-policy.p_11')}}</p>
                    <p>{{trans('page/privacy-policy.p_12')}}</p>
                    <p>{{trans('page/privacy-policy.p_13')}}</p>
                    <p>{{trans('page/privacy-policy.p_14')}}</p>
                    <p>{{trans('page/privacy-policy.p_15')}}</p>
                </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_5')}}</h4>
                    <p>{{trans('page/privacy-policy.p_16')}}</p>
                    <p>{{trans('page/privacy-policy.p_17')}}</p>
                    <p>{{trans('page/privacy-policy.p_18')}}</p>
                </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_6')}}</h4>
                    <p>{{trans('page/privacy-policy.p_19')}}</p>
                    <p>{{trans('page/privacy-policy.p_20')}}</p>
                    <p>{{trans('page/privacy-policy.p_21')}}</p>
                    <p>{{trans('page/privacy-policy.p_22')}}</p>
                    <p>{{trans('page/privacy-policy.p_23')}}</p>
                    <p>{{trans('page/privacy-policy.p_24')}}</p>
                    <p>{{trans('page/privacy-policy.p_25')}}</p>
                    <p>{{trans('page/privacy-policy.p_26')}}</p>
                    <p>{{trans('page/privacy-policy.p_28')}}</p>
                    <p>{{trans('page/privacy-policy.p_29')}}</p>
                </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_7')}}</h4>
                    
                    <p>{{trans('page/privacy-policy.p_30')}}</p>
                    <p>{{trans('page/privacy-policy.p_31')}}</p>
                    <p>{{trans('page/privacy-policy.p_32')}}</p>
                    <p>{{trans('page/privacy-policy.p_33')}}</p>
                    <p>{{trans('page/privacy-policy.p_34')}}</p>
                    <p>{{trans('page/privacy-policy.p_35')}}</p>
                    <p>{{trans('page/privacy-policy.p_36')}}</p>
                    <p>{{trans('page/privacy-policy.p_37')}}</p>
                </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_8')}}</h4>
                    
                    <p>{{trans('page/privacy-policy.p_38')}}</p>
                    <p>{{trans('page/privacy-policy.p_39')}}</p>
                </div>
                <div class="faq_inner">
                    <h4>{{trans('page/privacy-policy.h_9')}}</h4>
                    
                    <p>{{trans('page/privacy-policy.p_40')}}</p>
                    <p>{{trans('page/privacy-policy.p_41')}}</p>
                    <p>{{trans('page/privacy-policy.p_42')}}</p>
                </div>
                
            </div>
        </section>

@endsection
