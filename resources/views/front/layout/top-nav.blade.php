<header>
  <div class="top_section">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <ul class="top_left_ul">
            <li><i class="fa fa-envelope-o"></i>{{trans('front/layout/top-nav.Email')}}</li>
            <!--<li><i class="fa fa-phone"></i>{{trans('front/layout/top-nav.Call')}}</li>-->
          </ul>
        </div>
        <div class="col-md-6 col-sm-6">
		<form>
			<div class="flag_right">
				<div class="flagstrap" id="select_country" data-input-name="NewBuyer_country" data-selected-country=""></div>
			</div>
		</form>
          
         </div>
      </div>
    </div>
  </div>
  <div class="menu_section">
    <div class="container">
      <div class="row">
          <div class="col-md-4 col-sm-8">
            <a href="{{ url('/') }}"><img class="logo" src="{{ asset('images/logo.png') }}" alt="img"></a>
          </div>
          <div class="col-md-8 col-sm-8">
            <div id="cssmenu">
              <ul>
						<li><a href="{{ route('exchange') }}">{{trans('front/layout/top-nav.Exchange')}}</a></li>
					@guest
						<li><a href="{{ route('register') }}">{{trans('front/layout/top-nav.Register')}}</a></li>
						<li><a href="{{ route('login') }}">{{trans('front/layout/top-nav.Login')}}</a></li>
					@endguest

					@auth
						<li>
							<a href="javascript:void(0)" class="dropbtn" >{{trans('front/layout/top-nav.Account')}}</a>
							<ul>
								<li><a href="{{ route('account.index') }}">{{trans('front/layout/top-nav.Deposits_Withdrawals')}}</a></li>
								<li><a href="{{ route('account.history')}}">{{trans('front/layout/top-nav.History')}}</a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0)" class="dropbtn" >{{trans('front/layout/top-nav.Order')}}</a>
							<ul>
								<li><a href="{{ route('order.open') }}">{{trans('front/layout/top-nav.My_Open_Order')}}</a></li>
								<li><a href="{{ route('order.history') }}">{{trans('front/layout/top-nav.Trade_History')}}</a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0)">{{ auth()->user()->full_name }}</a>
							<ul>
								<li><a href="{{ route('profile') }}">{{trans('front/layout/top-nav.My_Profile')}} </a></li>
								<li><a href="{{ route('profile.referra-code') }}">{{trans('front/layout/top-nav.My_Referral')}}</a></li>
								<li><a href="{{ route('profile.2fa') }}">{{trans('front/layout/top-nav.Security')}}</a></li>
								<li><a style="cursor: hand" onclick="document.getElementById('logout-form').submit();">{{trans('front/layout/top-nav.Logout')}}</a></li>
								<form method="post" action="{{ route('logout') }}" id="logout-form">
									{{ csrf_field() }}
								</form>
							</ul>
						</li>
					@endauth
                    </ul>
            </div>
           </div>
      </div>
    </div>
  </div>
</header>


