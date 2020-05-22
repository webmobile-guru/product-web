@php $mode = session()->get('mode'); $mode = !($mode)?'live':$mode; @endphp
@php
$query = new \App\PriceQuote;
$query->setConnection('live');
$coinPaymentPrice = $query->selectRaw('symbol,price')->where('status',1)->get();
@endphp

    @if(\App\Repository\News\AdminNews::instance()->isNotification())
    <div class="row">
      <div class="col-md-12 col-sm-12">
        
          @foreach (\App\Repository\News\AdminNews::instance()->news() as $value) 
          <div class="alert alert-warning headerNews" style="border-radius: 0px; margin-bottom:0">{!!$value['des']!!}</div>
          @endforeach
      </div>
    </div>
    @endif

<header>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-4">
        <a href="{{route('home')}}"><img class="logo" src="/doch/img/logo.png" alt=""></a>
        <ul class="top_left_menu">
          <li><a href="{{ route('exchange.index') }}"><span><i class="fa fa-th"></i></span> {{trans('front/layout/user-header.Exchange')}}</a></li>
          <!--<li><a href="javascript void(0)">Markets</a></li>
          <li><a href="javascript void(0)">Lending</a></li>-->
        <ul>
      </div>
      <div class="col-md-8 col-sm-8">
        <div class="menu_section">
           <div id="cssmenu">
              <ul>
              
              <!--<li><a {{ request()->is('announcement')?"class=active":'' }} href="{{ url('announcement') }}"><i class="fa fa-bullhorn"></i></a></li>-->

                 <!-- <li><a href="JavaScript:void(0);">Support</a>
                    <ul>
                      <li><a href="JavaScript:void(0);">Support Center</a>
                      <li><a href="JavaScript:void(0);">Submit a request</a>
                      <li><a href="JavaScript:void(0);">FAQ</a>
                      <li><a href="JavaScript:void(0);">Downloads</a>
                      <li><a href="JavaScript:void(0);">API Documentation</a>
                    </ul>
                  </li>
                  <li><a href="JavaScript:void(0);">More</a>
                    <ul>
                      <li><a href="JavaScript:void(0);">Announcements</a>
                      <li><a href="JavaScript:void(0);">Careers</a>
                      <li><a href="JavaScript:void(0);">About Us</a>
                      <li><a href="JavaScript:void(0);">Listing Application</a>
                      <li><a href="JavaScript:void(0);">Community</a>
                      <li><a href="JavaScript:void(0);">Doch Coin</a>
                    </ul>
                  </li>-->
                  @php 
                      $user = auth()->user();
                  @endphp
                  <li><a href="JavaScript:void(0);">
                    @if($user->profile->avatar != '')
                        <img class="header_icon" alt="User Pic" src="{{ route('photo.get', [$user->profile->avatar]) }}" class="img-circle img-responsive">
                    @else
                        <img alt="User Pic" src="{{url('img/nobody_m.original.jpg')}}" class="header_icon">
                    @endif  
                 {{-- {{trans('front/layout/user-header.My_Account')}} --}}</a>
                    <ul>
                      <li>
                        <a href="{{ route('profile') }}">{{trans('front/layout/user-header.MyProfile')}}</a>
                      </li>
                      <li><a {{ request()->is('account')?"class=active":'' }} href="{{ route('account.index') }}">{{trans('front/layout/user-header.Wallets')}}</a></li>
                      <li><a {{ request()->is('account/history')?"class=active":'' }} href="{{ route('account.history') }}">{{trans('front/layout/user-header.Deposit_Withdrawal_History')}}</a></li>
                      <li><a {{ request()->is('order/open')?"class=active":'' }} href="{{ route('order.open') }}">{{trans('front/layout/user-header.My_Trades')}}</a></li>
                      <li><a {{ request()->is('transactions')?"class=active":'' }} href="{{ route('transactions.getTransactions') }}">{{trans('front/layout/user-header.Transactions')}}</a></li>
                      <li><a {{ request()->is('security/two-factor')?"class=active":'' }} href="{{ route('security.2fa') }}">{{trans('front/layout/user-header.Security_Settings')}}</a></li>
                      
                     <li>
                        <a href="#" style="background: #272a2f; border-top: 1px solid #35373b;">
                        <div class="live_demo {{($mode=='live')?'text-success':'text-warning'}}">
                          <div class="live_demo_inner">
                            <span class="live_demo_circle"></span>
                            <span class="live_demo_text">{{($mode=='live')?trans("front/layout/user-header.Live"):trans("front/layout/user-header.Demo")}}</span>
                          </div>
                            <label class="switch" for="checkbox">
                                <input class="state" id="checkbox"  onchange="window.location='{!! route('account.switch') !!}'" type="checkbox" data-on="Live" data-off="Demo" data-onstyle="success" data-offstyle="warning" data-toggle="toggle" data-size="large" {{($mode=='live')?'checked':''}}/>
                                <div class="slider round"></div>
                            </label>
                        </div>
                        </a>
                    </li>
                   </ul>
                  </li>
                 

                  @if(Session::get('adminLogin'))		
                  <li><a href="{{ route('loginAsAdmin') }}"><i class="icon-refresh"></i> <span>{{trans('front/layout/user-header.Back_To_Administrator')}}</span></a></li>
                  @endif
                  
                  <li><a class="register_btn" href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> {{trans('auth/verify-twofa.Logout')}}</a></li>
              </ul>
              <form id="logout-form" action="{{ route('logout') }}" method="post">
                  {{ csrf_field() }}
              </form>
          </div> 
        </div>
      </div>
    </div>
  </div>
</header>

