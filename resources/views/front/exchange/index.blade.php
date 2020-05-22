@php $user = auth()->user();@endphp
@extends('front.user')
@section('content')
    @guest
		@include('front.layout.guest-header')
	@else
		@include('front.layout.user-header')
	@endguest



<div class="exc_section">
  <div class="container">
    <div class="part_row">
      <div class="part01">
        
        <div class="exchange_rate">
          <div class="mobile_view">
            <div class="market_top_bg">
                <p>{{trans('front/exchange/index.Market')}} <span class="text-info codename"></span></p>
            </div>
          </div>
          <ul class="exchange_rate_ul">
            <li><span>{{trans('front/exchange/index.Market')}}</span><p class="codename text-info"></p></li>
            <li class="green"><span>{{trans('front/exchange/index.Last_Price')}}</span><p class="last"></p></li>
            <li><span>{{trans('front/exchange/index.24Hr_Volume')}}</span><p><p class="quoteVolume"></p> <p class="quoteCurrency"></p></li>
            <li><span>{{trans('front/exchange/index.24Hr_Volume')}}</span> <p><p class="baseVolume"></p> <p class="baseCurrency"></p></li>
            <li class="red"><span>{{trans('front/exchange/index.24hr_High')}}</span><p class="high text-success"></p></li>
            <li><span>{{trans('front/exchange/index.24hr_Low')}}</span><p class="para_color low text-danger"></p></li>
            <li class="yellow"><span>{{trans('front/exchange/index.Change_24Hrs')}}</span><p class="changePercent"></p></li>
         </ul>
        </div>
          <!--mobile market-->
          <div class="mobile_view">
              <div class="ex_border">
              <div class="market_inner">
                <ul class="nav nav-tabs markets-tabs">
                    @php $baseCoins = \App\Coin::active()->where('is_base',1)->get(); @endphp
                    @foreach($baseCoins as $coin)
                        <li class="nav-item market{{ $coin->coin }}">
                            <a class="nav-link" role="tab" data-toggle="tab" href="#menu{{$coin->coin}}">{{$coin->coin}} </a>
                        </li>
                    @endforeach
                </ul>
                    <div class="tab-content market_star">
                        {{--<div class="tabletop_bg"><h5>Market <span class="name">BTC</span></h5></div>--}}
                        @php $baseCoins = \App\Coin::active()->where('is_base',1)->get(); @endphp
                        @foreach($baseCoins as $coin)
                            <div role="tabpanel" id="menu{{$coin->coin}}" class="markets tab-pane{{($coin->coin=='BTC') ? ' tab-pane active' : '' }}">
                                <div class="table-responsive star_table">
                                    <div class="tableFixHead market_height">
                                        <table class="table market_table" id="market{{$coin->coin}}" >
                                            <thead>
                                            <tr>
                                                <th>{{trans('front/exchange/index.Name')}}</th>
                                                <th>{{trans('front/exchange/index.Price')}}</th>
                                                <th>{{trans('front/exchange/index.Volume')}}</th>
                                                <th>{{trans('front/exchange/index.Change')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
              </div>
          </div>
          <!--mobile market-->
          <!--mobile graph-->
          <div class="mobile_view">
            <div class="graph_inner" style="display: none">
                <img src="/doch/img/graph.jpg" alt="">
            </div>
          </div>
          <!--mobile graph-->
          <div class="part_row">
            <div class="part02">
              <div class="ex_border">
                <div class="sellOrders">
                    <div class="table-resonsive">
                        <div class="tableFixHead">
                            <div class="data"></div>
                        </div>
                    </div>
                </div>
                <div class="table_strip"> 
                    <div class="text-success"><span class="baseCurrencyLastPrice">0.00000000</span><span class="baseCurrencyLastPriceUSD"> </span></div>  
                    {{-- <span class="more_table"><i class="fa fa-signal text-info"></i></span> --}}
                </div>
                <div class="buyOrders">
                    <div class="table-resonsive">
                        <div class="tableFixHead">
                            <div class="data"></div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="part03">
              <div class="graph_inner desktop_view">
                <div class="ex_border">
                    <div id="chartContainer"></div>
                </div>
               
              </div>
              <div class="ex_border buy_sell_tab">
                <ul class="nav nav-tabs ">
                  <li class="nav-item">
                    <a class="nav-link active" href="#buy_sell" role="tab" data-toggle="tab">LIMIT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#stop_limt" role="tab" data-toggle="tab">STOP-LIMIT</a>
                  </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="buy_sell">
                        <div class="exchange_bg">
                            <div class="part_row">
                                <div class="part_50 buysell_border">
                                    <div class="buysell_padding buyCol">
                                    <div class="buy_sell_input">
                                    <h4>{{trans('front/exchange/index.BUY')}} <span class="name"></span>
                                    <span class="wallet_img">{{trans('front/exchange/index.Lowest_Ask')}} : <span class="primaryCurrency"></span> <span id="lowestAsk" class="lowest_aks"></span></span>
                                    </h4>
                                <div class="exch_padding">
                                    <form method="get" id="buyForm" action="{{ url('/buy') }}">
                                        <div class="buy_sell_input_area">
                                            <div class="buysell_price">{{trans('front/exchange/index.Price')}} :</div>
                                            <input class="buy_sell_i" type="text" name="buyRate" id="buyRate">
                                            <div class="buysell_coin sortName_price"></div>
                                        </div>
                                        <div class="buy_sell_input_area">
                                            <div class="buysell_price">{{trans('front/exchange/index.Amount')}} :</div>
                                            <input class="buy_sell_i" type="text" name="buyAmount" id="buyAmount">
                                            <div class="buysell_coin sortName_amount"></div>
                                        </div>
                                        <div class="buy_sell_input_area">
                                            <div class="buysell_price">{{trans('front/exchange/index.Total')}} :</div>
                                            <input class="buy_sell_i" type="text" name="buyTotal" id="buyTotal">
                                            <div class="buysell_coin sortName_total"></div>
                                        </div>
                                        <div class="buy_sell_input_area">
                                            <div class="buysell_price">{{trans('front/exchange/index.Fees')}} :</div>
                                            <input class="buy_sell_i" type="text" disabled name="buyfees" id="buyfees" >
                                            <div class="buysell_coin fee_sortName_amount"></div>
                                        </div>
                                        <div class="have_text_padding">
                                            <p class="have_text"><img src="/doch/img/wallet.png" alt=""> 
                                             <span class="primaryCurrency"></span> <span class="offerdashed" id="primaryBalance"></span>
                                            </p>
                                            {{-- <ul class="ul_100">
                                                <li>10%</li>
                                                <li>20%</li>
                                                <li>50%</li>
                                                <li>100%</li>
                                            </ul> --}}
                                        </div>
                                        @guest
                                            
                                       

                                        <p class="buy_text_link">
                                            <a href="{{ url('login') }}"> {{trans('front/exchange/index.Login')}}</a> {{trans('front/exchange/index.Or')}}
                                            <a href="{{ url('register') }}"> {{trans('front/exchange/index.Register')}}</a> {{trans('front/exchange/index.to_trade')}}
                                        </p>
                                            
                                        @else
                                            <button class="buy_buy_btn sell_btn" type="submit">{{trans('front/exchange/index.Buy')}}</button>
                                        @endguest
                                    </form>
                                </div>
                            </div>
                        
                                    </div>
                                </div>
                                <div class="part_50">
                                    <div class="buysell_padding sellCol">
                        <div class="buy_sell_input">
                            <h4>{{trans('front/exchange/index.Sell')}} <span class="name"></span>
                            <span class="wallet_img">{{trans('front/exchange/index.Highest_Bid')}}  : <span class="primaryCurrency"></span> <span id="highestBid" class="high_bid"></span></span>
                            </h4>
                            <div class="exch_padding">
                                
                                <form id="sellForm" method="get" action="{{url('/sell')}}">
                                    <div class="buy_sell_input_area">
                                        <div class="buysell_price">{{trans('front/exchange/index.Price')}} :</div>
                                        <input class="buy_sell_i" type="text" name="sellRate" id="sellRate">
                                        <div class="buysell_coin sortName_price"></div>
                                    </div>
                                    <div class="buy_sell_input_area">
                                        <div class="buysell_price">{{trans('front/exchange/index.Amount')}} :</div>
                                        <input class="buy_sell_i" type="text"  name="sellAmount" id="sellAmount">
                                        <div class="buysell_coin sortName_amount"></div>
                                    </div>
                                    <div class="buy_sell_input_area">
                                        <div class="buysell_price">{{trans('front/exchange/index.Total')}} :</div>
                                        <input class="buy_sell_i" type="text" name="sellTotal" id="sellTotal">
                                        <div class="buysell_coin sortName_total"></div>
                                    </div>
                                    <div class="buy_sell_input_area">
                                        <div class="buysell_price">{{trans('front/exchange/index.Fees')}} :</div>
                                        <input class="buy_sell_i" type="text" disabled name="sellfees" id="sellfees">
                                        <div class="buysell_coin fee_sortName_amount"></div>
                                    </div>
                                    <div class="have_text_padding">
                                        <p class="have_text"><img src="/doch/img/wallet.png" alt=""> 
                                        <span class="secondaryCurrency"></span> <span id="secondaryBalance"></span>
                                        </p>
                                        {{-- <ul class="ul_100">
                                            <li>10%</li>
                                            <li>20%</li>
                                            <li>50%</li>
                                            <li>100%</li>
                                        </ul> --}}
                                    </div>
                                    @guest
                                    <p class="buy_text_link">
                                        <a href="{{ url('login') }}"> {{trans('front/exchange/index.Login')}}</a> {{trans('front/exchange/index.Or')}}
                                        <a href="{{ url('register') }}"> {{trans('front/exchange/index.Register')}}</a> {{trans('front/exchange/index.to_trade')}}
                                    </p>
                                    @else
                                        <button class="buy_sell_btn" type="submit">{{trans('front/exchange/index.Sell')}}</button>
                                    @endguest
                                </form>
                            </div>
                        </div>
                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="stop_limt">
                    <div class="buysell_padding stopCol">
                    <div class="buy_sell_input stop_limit_width">
                        <h4>{{trans('front/exchange/index.STOP_LIMIT')}}
                            <div class="stopLimitWallet">
                            <span class="stopLimitWallet_img"><img src="/doch/img/wallet.png" alt=""> <span class="primaryCurrency"></span> <span id="stopLimitPrimaryBalance"></span></span>
                            <span class="stopLimitWallet_img"><img src="/doch/img/wallet.png" alt=""> <span class="secondaryCurrency"></span> <span id="stopLimitSecondaryBalance"></span></span>
                            </div>
                        </h4>
                        <div class="exch_padding" style="margin-top: 40px;">
                            
                            <form id="stopLimitForm" method="get" action="{{url('/stop-limit')}}">
                                <input type="hidden" name="stopLimitCommand" id="stopLimitCommand" value="buy">
                                <div class="buy_sell_input_area">
                                    <div class="buysell_price">{{trans('front/exchange/index.Stop')}} :</div>
                                    <input class="buy_sell_i" type="text" name="stopLimitStopRate" id="stopLimitStopRate">
                                    <div class="buysell_coin sortName_price"></div>
                                </div>
                                <div class="buy_sell_input_area">
                                    <div class="buysell_price">{{trans('front/exchange/index.Limit')}} :</div>
                                    <input class="buy_sell_i" type="text"  name="stopLimitRate" id="stopLimitRate">
                                    <div class="buysell_coin sortName_amount"></div>
                                </div>
                                <div class="buy_sell_input_area">
                                    <div class="buysell_price">{{trans('front/exchange/index.Amount')}} :</div>
                                    <input class="buy_sell_i" type="text" name="stopLimitAmount" id="stopLimitAmount">
                                    <div class="buysell_coin sortName_total"></div>
                                </div>
                                <div class="buy_sell_input_area">
                                    <div class="buysell_price">{{trans('front/exchange/index.Total')}} :</div>
                                    <input class="buy_sell_i" type="text" name="stopLimitTotal" id="stopLimitTotal">
                                    <div class="buysell_coin fee_sortName_amount"></div>
                                </div>
                                
                                @guest
                                <p class="buy_text_link">
                                        <a href="{{ url('login') }}"> {{trans('front/exchange/index.Login')}}</a> {{trans('front/exchange/index.Or')}}
                                        <a href="{{ url('register') }}"> {{trans('front/exchange/index.Register')}}</a> {{trans('front/exchange/index.to_trade')}}
                                    </p>
                                @else
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6 col_padding">
                                        <button id="stopLimitBuy" class="buy_buy_btn" type="submit" name="buy">{{trans('front/exchange/index.Buy')}}</button>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 col_padding">
                                        <button id="stopLimitSell" class="buy_sell_btn" type="submit" name="sell">{{trans('front/exchange/index.Sell')}}</button>
                                    </div>
                                </div>
                                    
                                    
                                @endguest
                            </form>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
              </div>  
            </div>
          </div>  
          
      </div>
      <div class="part02">
        <div class="ex_border desktop_view">
          <div class="market_inner">
              <ul class="nav nav-tabs markets-tabs">
                @php $baseCoins = \App\Coin::active()->where('is_base',1)->get(); @endphp
                @foreach($baseCoins as $coin)
                    <li class="nav-item market{{ $coin->coin }}">
                        <a class="nav-link" role="tab" data-toggle="tab" href="#menuD{{$coin->coin}}">{{$coin->coin}} </a>
                    </li>
                @endforeach
              </ul>
            <div class="tab-content market_star">
                {{--<div class="tabletop_bg"><h5>Market <span class="name">BTC</span></h5></div>--}}
                @php $baseCoins = \App\Coin::active()->where('is_base',1)->get(); @endphp
                @foreach($baseCoins as $coin)
                    <div role="tabpanel" id="menuD{{$coin->coin}}" class="markets tab-pane{{($coin->coin=='BTC') ? ' tab-pane active' : '' }}">
                        <div class="table-responsive star_table">
                            <div class="tableFixHead order_hight ">
                                <table class="table market_table table-hover" id="market{{$coin->coin}}" >
                                    <thead>
                                    <tr>
                                        <th>{{trans('front/exchange/index.Name')}}</th>
                                        <th>{{trans('front/exchange/index.Price')}}</th>
                                        <th>{{trans('front/exchange/index.Volume')}}</th>
                                        <th>{{trans('front/exchange/index.Change')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
        <h6 class="exc_heading">{{trans('front/exchange/index.Order_History')}}</h6>
        <div class="ex_border">
          <div class="table-responsive">
              <div class="tableFixHead order_hight">			
              <div class="marketTrades"></div>
              </div>
          </div>
        </div>
        
      </div>
    </div>

    <h6 class="open_order_h">{{trans('front/exchange/index.Open_Orders')}}</h6>
    <div class="ex_border open_table">
        <div class="table-responsive">
            @if(Auth::check())
                <div class="tableFixHead">
                    <div class="openOrders"></div>
                </div>
                @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Method</th>
                            <th>Trigger Condition</th>
                            <th>Price (BTC)</th>
                            <th>Amount (LTC)</th>
                            <th>Total (BTC)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>  
                <img class="empty_table_img" src="/doch/img/empty.png" alt="">
            @endif

            
        </div>
    </div>
  </div>
</div>










<!---end-->
@if(auth()->check())
    <!-- start chat box -->
    <div class="chatbox-holder">
        <div class="chatbox chatbox-min">
            <div class="chatbox-top fa-minus">
                <div class="chatbox-avatar">
                    @if($user->profile->avatar != '')
                        <img class="user_icon" alt="User Pic" src="{{ route('photo.get', [$user->profile->avatar]) }}" class="img-circle img-responsive">
                    @else
                        <img alt="User Pic" src="{{ asset('img/nobody_m.original.jpg') }}" class="user_icon">
                    @endif
                </div>
                <div class="chat-partner-name">
                    <span class="troll_text">{{trans('front/exchange/index.Troll_Box')}}</span>
                    <span class="status donot-disturb"></span>
                    {{ $user->full_name }}
                </div>
                <div class="chatbox-icons ">
                   
                   <!-- <a href="javascript:void(0);"><i class="fa fa-plus"></i></a>-->
                    <a href="javascript:void(0);"><i class="fa fa-close"></i></a>
                </div>
            </div>

            <div class="chat-messages">

            </div>

            <div class="chat-input-holder">
                <form action="{{ route('exchange.post.troll') }}" method="post" id="chat-message" style="width:100%">
                    <input type="text" class="buy_sell_i chart_input" id="troll-item" placeholder="Type your message..">
                    <button class="chart_submit" type="submit" value="Send" class="message-send" id="send-troll"><i class="fa fa-paper-plane-o"></i></button>
                    
                </form>
            </div>

        </div>
    </div>
    <!-- end chat box -->
@endif
@endsection
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"/>
<style>
    table.market_table tbody tr{ cursor: pointer !important;}
    .marketTrades tr.sell { background: #e4bcb8; color: #a42015;}
    .marketTrades tr.buy {background: #c1dec8; color: #339349}
    .standard {
        padding: 0.05em 0.5em;
        cursor: pointer;
        color: rgb(51, 51, 51);
        background: rgb(255, 255, 255);
        border-width: 1px;
        border-style: solid;
        border-color: rgb(230, 230, 230);
        border-image: initial;
        outline: none;
    }
</style>
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('js/market.js') }}?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('js/chart.js') }}?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('js/canvasjs.min.js') }}?v={{time()}}"></script>
<script type="text/javascript" src="{{ asset('js/customchart.js') }}?v={{time()}}"></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
<script>
	$(function(){
  $('.fa-minus').click(function(){    $(this).closest('.chatbox').toggleClass('chatbox-min');
  });
  $('.fa-close').click(function(){
    $(this).closest('.chatbox').hide();
  });
});

</script>
<script type="text/javascript">

		$('.mt-clipboard').click(function () {
            Command: toastr["success"]("The referral code is copied to your clipboard.", "Copied");

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        });
	
	var ajaxUrl = $('base').attr('href');
    var mode = '{{ session()->get('mode')?:'live'}}';
	var usid = @if(Auth::check()){{Auth::user()->id}}@else  false @endif;
	var uname = @if(Auth::check())'{{Auth::user()->full_name}}'@else  false @endif;
	var loggedIn = @if(Auth::check()) true @else false @endif;
	var makerFee = {!! \App\Setting::getFees('maker_fee') !!};
	var takerFee = {!! \App\Setting::getFees('taker_fee') !!};
	var primaryCurrency = 'BTC';
	var secondaryCurrency = 'ETH';
	var currencyPair = 'BTC_ETH';

	var currencyPairArray = {!! $coinPairs !!};

	var currencyNamesArray = {!! $coinPairName !!};

	var marketEventQueue = {};
    var available = {!! $availables !!};
    
    $(document).ready(function(){
       
        var currentMarket = window.location.hash;
        currentMarket = currentMarket.replace("#","");
        var active_currentMarket = currentMarket.split("_")[0];
       // $('.markets-tabs li:nth-child(' + id + ') a').click();
       $('.markets-tabs li.market'+active_currentMarket.toUpperCase()+' a').click();
    })
    
</script>

<script type="text/javascript">
	var maxDecimals = 8;
	function exactRound(num, decimals) {
		if (decimals<0)decimals=0;
		var sign = num >= 0 ? 1 : -1;
		return (Math.round((num * Math.pow(10, decimals)) + (sign * 0.001)) / Math.pow(10, decimals))
				.toFixed(decimals);
	}
</script>
<script type="text/javascript" src="{{ asset('js/exchanges.js') }}?v={{time()}}"></script>
{{--<script type="text/javascript" src="{{ asset('js/jquery.jscrollpane.min.js') }}"></script>--}}
<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
@endpush
