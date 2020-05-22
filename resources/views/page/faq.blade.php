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
            <h2>{{trans('page/faq.Frequently_Asked_Questions')}}</h2>
        </div>

        <div class="accordion_box">
            <div class="accordion_inner">
                <div class="accordion_head">{{trans('page/faq.SIGN_UP')}}<span class="plusminus">-</span></div>
                <div class="accordion_body">
                    <p>{{trans('page/faq.Enter_your_email_address_password')}}</p>
                </div>
            </div>
        </div>
        <div class="accordion_box">
            <div class="accordion_inner">
                <div class="accordion_head">{{trans('page/faq.LOGIN_PASSWORD')}}<span class="plusminus">+</span></div>
                <div class="accordion_body" style="display: none;">
                  <p>{{trans('page/faq.Enable_TwoFactor_Authentication')}} </p>
                  <p>{{trans('page/faq.Change_your_password')}}</p>
                </div>
            </div>
        </div>
        <div class="accordion_box">
            <div class="accordion_inner">
                <div class="accordion_head">{{trans('page/faq.DEPOSIT_WITHDRAWAL')}}<span class="plusminus">+</span></div>
                <div class="accordion_body" style="display: none;">
                  <p>{{trans('page/faq.How_to_Deposit_Doch')}}</p>
                  <p>{{trans('page/faq.Login_your_account_Deposit')}} </p>
                  <p>{{trans('page/faq.How_to_Withdraw_Doch')}}</p>
                  <p>{{trans('page/faq.Login_to_your_account_Withdraw')}}</p>
                </div>
            </div>
        </div>
        <div class="accordion_box"> 
            <div class="accordion_inner">
                <div class="accordion_head">{{trans('page/faq.WALLET')}}<span class="plusminus">+</span></div>
                <div class="accordion_body" style="display: none;">
                  <p><strong>{{trans('page/faq.If_entered_incorrect_wallet')}} –</strong></p>
                  <p>{{trans('page/faq.Due_to_the_nature_of_Digital_Currencies')}}</p>
                  <p><strong>{{trans('page/faq.transaction_delayed')}} – </strong></p>
                  <p>{{trans('page/faq.The_time_to_complete_transaction')}}</p>
                  <p><strong>{{trans('page/faq.Cryptocurrency_withdrawal_disabled')}} –</strong></p>
                  <p>{{trans('page/faq.There_canbe_certain_situations')}}</p>
                  <p>{{trans('page/faq.Withdrawal_process_starts_automatically')}}</p>
                </div>
            </div>
        </div>
        <div class="accordion_box">
            <div class="accordion_inner">
                <div class="accordion_head">{{trans('page/faq.SUPPORT')}}<span class="plusminus">+</span></div>
                <div class="accordion_body" style="display: none;">
                  <p><strong>{{trans('page/faq.here_to_help')}}</strong></p>
                  <p>{{trans('page/faq.Reachout_to_our_support_centre')}} </p>
                </div>
            </div>
        </div>
       
      
    </div>
</section>


@endsection
