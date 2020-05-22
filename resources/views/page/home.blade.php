@extends('front.user')
@section('content')
@guest
    @include('front.layout.guest-header')
@else
    @include('front.layout.user-header')
@endguest


<div class="slider_section">
  <div id="slider" class="carousel slide" data-ride="carousel">

  
    <!-- The slideshow -->
    <div class="carousel-inner">

      <div class="carousel-item active">
        <div class="slider_img" style="background: url(/doch/img/doch_slider.jpg?cbxxcd)";>
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-sm-6"></div>
              <div class="col-md-6 col-sm-6">
                <div class="slider_text">
                  <h2>{{trans('page/home.slider_h_1')}} <span>{{trans('page/home.slider_s_1')}}</span></h2>
                  <p>{{trans('page/home.slider_p_1')}}</p>
                  <a class="slider_btn" href="{{ route('register') }}">{{trans('page/home.Register_now')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
      {{--
      <a class="carousel-control-prev" href="#slider" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#slider" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
      --}}
  </div>
</div>
<div class="slider_bottom market_item_padding">
  <div class="container">
    <div class="row" id="home_list_ticker">
        
    </div>
  </div>
</div>
<div class="sm_padding ">
  <div class="container">
  <div class="box-shadow">
        <div class="search_input_holder">
          <input id="ticker_coin_list_input" class="search_input" type="text" placeholder="{{trans('page/home.Search_coin_name')}}">
          <img src="/doch/img/search.png" alt="">
        </div>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#Favorites" role="tab" data-toggle="tab">{{trans('page/home.Favorites')}}</a>
          </li>
        </ul> 
        
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="Favorites">
            <div class="table-responsive">
              <table class="table home_star table-hover">
                  <thead>
                    <tr>
                      <th>{{trans('page/home.Pair')}}</th>
                      <th>{{trans('page/home.LastPrice')}}</th>
                      <th>{{trans('page/home.24hChange')}}</th>
                      <th>{{trans('page/home.Markets')}}</th>
                      <th>{{trans('page/home.24hVolume')}}</th>
                    </tr>
                  </thead>
                  <tbody id="ticker_list" class="ticker_coin_list">
                    
                  </tbody>
              </table>
            </div>
          </div>
        </div>
  </div>
  </div>
</div>
<div class="all_padding giwRVs">
  <div class="container icon_img">
    <div class="all_heading">
      <h2>{{trans('page/home.Experience_Lightning_Speed_Trading')}}</h2>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon1.png?yjd" alt="">
            <h2>{{trans('page/home.High_TPS')}}</h2>
            <p>{{trans('page/home.High_TPS_P')}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon2.png?fgx" alt="">
            <h2>{{trans('page/home.Powerful_Trade_Engine')}}</h2>
            <p>{{trans('page/home.Powerful_Trade_Engine_P')}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon3.png?dsd" alt="">
            <h2>{{trans('page/home.Hot_Wallet')}}</h2>
            <p>{{trans('page/home.Hot_Wallet_P')}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon4.png" alt="">
            <h2>{{trans('page/home.Multi_layer_Security')}}</h2>
            <p>{{trans('page/home.Multi_layer_Security_P')}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon5.png" alt="">
            <h2>{{trans('page/home.Market_Maker')}}</h2>
            <p>{{trans('page/home.Market_Maker_P')}}</p>
            </div>
        </div>
      
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon7.png" alt="">
            <h2>{{trans('page/home.KYC_and_AML')}}</h2>
            <p>{{trans('page/home.KYC_and_AML_P')}}</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="Experience_box">
            <img src="/doch/img/d_icon9.png" alt="">
            <h2>{{trans('page/home.Multi_Language_Support')}}</h2>
            <p>{{trans('page/home.Multi_Language_Support_P')}}</p>
          </div>
        </div>
    </div>
  </div>
</div>
<section class="app_section fbrfhA">
  <div class="container">
      <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="all_heading">
              <h2>{{trans('page/home.Trade_Anywhere')}}</h2>
            </div>
            <p>{{trans('page/home.Trade_Anywhere_P')}}</p>
            <div class="apptext_border">
              <img src="/doch/img/android.png">
              <h4>{{trans('page/home.Download')}}</h4>
              <p>{{trans('page/home.Android_app')}}</p>
            </div>
            <div class="apptext_border">
              <img src="/doch/img/ios.png">
             <h4>{{trans('page/home.Download')}}</h4>
              <p>{{trans('page/home.IOS_app')}}</p>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
              <img class="img-fluid" src="/doch/img/exchange_img.png?fgdhc" alt="">
          </div>
      </div>
  </div>
</section>


<div class="all_padding bg_color1 touch_section">
    <div class="container">
      <div class="all_heading">
        <h2>{{trans('page/home.Stay_Connected')}}</h2>
      </div>
      <div class="row text-center">
        <div class="col-md-3 col-sm-3">
          <div class="Experience_box">
            <img src="/doch/img/customer-support.png" alt="">
            <h2>{{trans('page/home.Customer_Support')}}</h2>
            <p>{{trans('page/home.We_are_here_to_resolve')}}</p>
          </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="Experience_box">
              <img src="/doch/img/newsletters.png?fvx" alt="">
              <h2>{{trans('page/home.Newsletters')}}</h2>
              <p>{{trans('page/home.Stay_updated_with_the_latest')}}</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="Experience_box">
              <img src="/doch/img/community.png?df" alt="">
              <h2>{{trans('page/home.Community')}}</h2>
              <p>{{trans('page/home.Join_the_Doch_community')}}</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="Experience_box">
              <img src="/doch/img/join-us.png" alt="">
              <h2>{{trans('page/home.Join_us')}}</h2>
              <p>{{trans('page/home.Build_your_future')}} </p>
            </div>
        </div>
      </div>
    </div>
</div>



<div class="trading_section all_padding">
  <div class="container">
    <div class="all_heading text-center">
      <h2>{{trans('page/home.Start_trading_now')}}</h2>
      <p>{{trans('page/home.slider_p_1')}}</p>
    </div>
    <div class="trading_section_button">
        <ul>
          <li><a href="{{ route('register') }}">{{trans('page/home.Register_now')}}</a></li>
          <li><a href="{{ route('exchange.index') }}">{{trans('page/home.Exchange_now')}}</a></li>
        </ul>
    </div>
  </div>
</div>
 


@endsection

@push('js')
<script type="text/javascript">
var url = $('base').attr('href');
  $(document).ready(function(){
    var maxDecimals = 8;
    function exactRound(num, decimals) {
      if (decimals<0)decimals=0;
      var sign = num >= 0 ? 1 : -1;
      return (Math.round((num * Math.pow(10, decimals)) + (sign * 0.001)) / Math.pow(10, decimals))
          .toFixed(decimals);
    }
    var html="";
    var displayPair = ["BTC_ETH","BTC_XRP","BTC_DASH","BTC_LTC"];
    $.getJSON(url+'/marketTreicker', function(d) {
      $.each( displayPair, function( key, value ) {
          console.log(d);
          var currentPairDetails = d[value];
          var pair = value.split("_")[1]+" / "+ value.split("_")[0];
          $("#home_list_ticker").append('<div class="col-md-3 col-sm-6"><div class="market_item"><img src="/doch/img/graph.png" alt=""><h5>'+pair+'</h5><h6><strong><span>'+exactRound(currentPairDetails.last,3)+'</span></strong></h6><p><span class="volume_red" style="margin-right: 8px;">'+exactRound(currentPairDetails.percentChange,2)+'</span><span>{{trans("page/home.Volume")}}:</span><span>'+currentPairDetails.baseVolume+'</span> <span>'+value.split("_")[0]+'</span></p></div></div>');
          $("#ticker_list").append('<tr><td>'+value.split("_")[1]+' <span class="text-muted">/ '+value.split("_")[0]+'</span></td><td>'+exactRound(currentPairDetails.last,3)+'</td><td class="volume_red">'+exactRound(currentPairDetails.percentChange,2)+'</td><td><img src="/doch/img/graph.png" alt=""></td><td>'+currentPairDetails.baseVolume+'</td></tr>')
      })
      
    });
  });
</script>
<script>
$(document).ready(function(){
  $("#ticker_coin_list_input").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".ticker_coin_list tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endpush
 
