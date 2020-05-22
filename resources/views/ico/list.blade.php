@extends('front.user')
@section('content')
        @guest
            @include('front.layout.guest-header')
        @else
            @include('front.layout.user-header')
        @endguest

        @if(count($hotIcos) > 0)
            <div class="icolist_text">
                <div class="container">
                    <div class="list_scroll">
                        <div id="ico_plan">
                            @foreach($hotIcos as $ico)
                                <div class="item">
                                    <div class="icolist_border">
                                        <a href="{{ route('ico.display', $ico->slug) }}">
                                            <div class="toplist_img">
                                                <img src="{{ url($ico->logo) }}" alt="">
                                                <h5>{{ $ico->title }}</h5>
                                                @if($ico->presale == 'yes')
                                                    <span class="preico_bg">{{trans('ico/list.Presale')}}</span>
                                                @endif
                                              
                                            </div>
                                            <div class="toplist_footer">
                                                <p>
                                                    <span class="start_date">{{ isset($ico->ico_start_at)?\Carbon\Carbon::parse($ico->ico_start_at)->toFormattedDateString():'TBD' }}</span>
                                                    <span class="end_date">{{ isset($ico->ico_end_at)?\Carbon\Carbon::parse($ico->ico_end_at)->toFormattedDateString():'TBD' }}</span>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif




<!--ico list-->
<section class="sm_padding">
    <div class="container">
        <div class="icolist_tab">
            <div class="row">
                <div class="col-md-8">
                    <ul class="nav nav-tabs tabs-left" id="myicoTab">
						<li @if(request()->is('ico')) class="active" @endif><a href="{{ route('ico.list') }}">{{trans('ico/list.Top_Picks')}}</a></li>
						<li @if(request()->is('ico/pre')) class="active" @endif><a href="{{ route('ico.list.pre') }}">{{trans('ico/list.Pre_ICOs')}}</a></li>
						<li @if(request()->is('ico/ongoing')) class="active" @endif><a href="{{ route('ico.list.ongoing') }}">{{trans('ico/list.Active_ICOs')}}</a></li>
						<li @if(request()->is('ico/upcoming')) class="active" @endif><a href="{{ route('ico.list.upcoming') }}">{{trans('ico/list.Upcoming_ICOs')}}</a></li>
						<li @if(request()->is('ico/past')) class="active" @endif><a href="{{ route('ico.list.past') }}">{{trans('ico/list.Past_ICOs')}}</a></li>
						<li @if(request()->is('ico/airdrops')) class="active" @endif><a href="{{ route('ico.list.airdrops') }}">{{trans('ico/list.Airdrops')}}</a></li>
					</ul>
                </div>
                <div class="col-md-4">
                    <form method="get" action="{{request()->url()}}">
                        <div class="ico_search_box">
							<select data-live-search="true" class="selectpicker form-control" name="category">
								<option value="">Choose ICO Type</option>
								<option value="Art">Art</option>
								<option value="Artificial intelligence">Artificial intelligence</option>
								<option value="Banking">Banking</option>
								<option value="Big Data">Big Data</option>
								<option value="Business Service">Business Service</option>
								<option value="Casino and Gambling">Casino and Gambling</option>
								<option value="Charity">Charity</option>
								<option value="Communications">Communications</option>
								<option value="Cryptocurrency">Cryptocurrency</option>
								<option value="Education">Education</option>
								<option value="Energy">Energy</option>
								<option value="Entertainment">Entertainment</option>
								<option value="Featured">Featured</option>
								<option value="Health">Health</option>
								<option value="Infrastructure">Infrastructure</option>
								<option value="Internet">Internet</option>
								<option value="Investment">Investment</option>
								<option value="Manufacturing">Manufacturing</option>
								<option value="Media">Media</option>
								<option value="Payments">Payments</option>
								<option value="Platform">Platform</option>
								<option value="Real Estate">Real Estate</option>
								<option value="Retail">Retail</option>
								<option value="Smart Contract">Smart Contract</option>
								<option value="Software">Software</option>
								<option value="Sports">Sports</option>
								<option value="Telecommunication">Telecommunication</option>
								<option value="Tourism">Tourism</option>
								<option value="Virtual Reality">Virtual Reality</option>
								<option value="Other">Other</option>
							</select>
                                       
							<input class="ico_search" placeholder="{{trans('ico/list.Keyword')}}..." name="keyword" value="{{ request()->keyword }}" >
                            <button class="ico_search_btn"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            
            
            <div class="tab-content icolisttable">
                <div class="tab-pane active" id="Active_ICO">
					<div class="icotopbg">
						<div class="icopart1"></div>
						<div class="icopart2">{{trans('ico/list.ICO')}}</div>
						<div class="icopart3">{{trans('ico/list.Description')}}</div>
						<div class="icopart4">{{trans('ico/list.Start')}}</div>
						<div class="icopart4">{{trans('ico/list.End')}}</div>
					</div>
					@foreach($icos as $ico)
						<div class="icoinner">
							<a href="{{ route('ico.display', $ico->slug) }}">
								<div class="icopart1">
									<img class="icosmimg" src="{{ url($ico->logo) }}" alt="">
								</div>
								<div class="icopart2">
									<h4 class="iconame">{{ $ico->title }}</h4>
									<span class="status-label {{ strtolower($ico->status) }}-ico">{{ $ico->status }}</span>
									@if($ico->presale == 'yes')
										<span class="status-label presale-ico">{{trans('ico/list.Presale')}}</span>
									@endif
									@if($ico->whitelist == 'yes')
										<span class="status-label whitelist-ico">{{trans('ico/list.Whitelist')}}</span>
									@endif
									@if($ico->hasTag('hot'))
										<span class="firetooltip"><i class="fas fa-fire"></i></span>
									@endif

								</div>
								<div class="icopart3">
									<p class="icodetails">{{ str_limit($ico->short_description, 130) }}</p>
								</div>
								<div class="icopart4">
									<span class="icodate">{{ isset($ico->ico_start_at)?\Carbon\Carbon::parse($ico->ico_start_at)->toFormattedDateString():'TBD' }}</span>
								</div>
								<div class="icopart4">
									<span class="icodate">{{ isset($ico->ico_end_at)?\Carbon\Carbon::parse($ico->ico_end_at)->toFormattedDateString():'TBD' }}</span>
								</div>
							</a>
						</div>
					@endforeach
				</div>
            </div>
                
            <div class="clearfix"></div>

        </div>
    </div>
</section>
<!--ico list-->  

<script>
	$("#ico_plan").owlCarousel({
		items : 4,
		itemsMobile : [479, 1],
		lazyLoad : true,
		navigation : true,
		autoPlay : true
		});
</script>
	
@endsection
