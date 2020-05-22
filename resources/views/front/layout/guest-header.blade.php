@php
$query = new \App\PriceQuote;
$query->setConnection('live');
$coinPaymentPrice = $query->selectRaw('symbol,price')->where('status',1)->get();
@endphp

<header>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-4">
        <a href="{{url('/')}}"><img class="logo" src="doch/img/logo.png?dgz" alt=""></a>
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
              
            <!--<li><a href="JavaScript:void(0);">Support</a>
                    <ul>
                      <li><a href="JavaScript:void(0);">Support Center</a>
                      <li><a href="JavaScript:void(0);">Submit a request</a>
                      <li><a href="{{ route('page.faq') }}">FAQ</a>
                      <li><a href="JavaScript:void(0);">Downloads</a>
                      <li><a href="JavaScript:void(0);">API Documentation</a>
                    </ul>
                  </li>
                  <li><a href="JavaScript:void(0);">More</a>
                    <ul>
                      <li><a href="JavaScript:void(0);">Announcements</a>
                      <li><a href="JavaScript:void(0);">Careers</a>
                      <li><a href="{{ route('page.about') }}">About Us</a>
                      <li><a href="JavaScript:void(0);">Listing Application</a>
                      <li><a href="JavaScript:void(0);">Community</a>
                      <li><a href="JavaScript:void(0);">Doch Coin</a>
                    </ul>
                  </li>-->
                <li><a class="register_btn" href="{{ route('login') }}">{{trans('front/layout/guest-header.Login/register')}}</a></li>
            </ul>
		 </div> 
        </div>
      </div>
    </div>
  </div>
</header>






