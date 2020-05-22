@extends('front.user')
@section('content')
@guest
    @include('front.layout.guest-header')
@else
    @include('front.layout.user-header')
@endguest

<section class="sm_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-3">
                <img class="icodetails_img" src="{{ url($ico->logo) }}" alt="">
            </div>
            <div class="col-md-10 col-sm-9">
                <h3 class="icodetails_name">{{ $ico->title }}</h3>
                <p class="icodetails_text">{!! $ico->short_description !!}</p>
					<ul class="icodetails_media">
                        @if($ico->link->twitter)
                            <li><a target="_blank" href="{{ $ico->link->twitter }}" title="ICO on twitter"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if($ico->link->facebook)
                            <li><a target="_blank" href="{{ $ico->link->facebook }}" title="ICO on facebook"><i class="fa fa-facebook-f"></i></a></li>
                        @endif
                        @if($ico->link->medium)
                            <li><a target="_blank" href="{{ $ico->link->medium }}"  title="ICO on medium"><i class="fa fa-medium"></i></a></li>
                        @endif
                        @if($ico->link->telegram)
                            <li><a target="_blank" href="{{ $ico->link->telegram }}" title="ICO on telegram"><i class="fa fa-paper-plane"></i></a></li>
                        @endif
                        @if($ico->link->bitcointalk)
                            <li><a target="_blank" href="{{ $ico->link->bitcointalk }}"  title="ICO on bitcointalk"><i class="fa fa-bitcoin"></i></a></li>
                        @endif
                        @if($ico->link->reddit)
                            <li><a target="_blank" href="{{ $ico->link->reddit }}"  title="ICO on bitcointalk"><i class="fa fa-reddit"></i></a></li>
                        @endif
                        @if($ico->link->slack)
                            <li><a target="_blank" href="{{ $ico->link->slack }}"  title="ICO on slack"><i class="fa fa-slack"></i></a></li>
                        @endif
                        @if($ico->link->discord)
                            <li><a target="_blank" href="{{ $ico->link->reddit }}"  title="ICO on discord app"><i class="fa fa-asterisk"></i></a></li>
                        @endif
                        @if($ico->link->github)
                            <li><a target="_blank" href="{{ $ico->link->github }}"  title="ICO on github"><i class="fa fa-github"></i></a></li>
                        @endif
                    </ul>
                <ul class="icodetails_whitpaper">
                     <li><a target="_blank" href="{{ $ico->link->whitepaper }}" ><i class="fa fa-file-text-o"></i> {{trans('ico/display.whitepaper')}}</a></li>
                     <li><a target="_blank" href="{{ $ico->link->website }}" ><i class="fa fa-globe"></i> {{trans('ico/display.website')}}</a></li>
                 </ul>
             </div>
        </div>

        <div class="details_inner">
           
            <div class="row">
                <div class="col-md-8 col-sm-8">
					{{--@php  preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $ico->link->video, $matches); dd($matches);@endphp--}}
                        <iframe src="{{ $ico->link->video }}" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" ></iframe>
                        {!! nl2br($ico->feature_description) !!}
                    <h3 class="icodetails_name">{{trans('ico/display.Team_members_and_advisors')}}</h3>
					<ul class="details_user_ul">
						@php $teams = $ico->team; @endphp

						@foreach($teams as $team)
							<li>
								<a target="_blank" href="{{ $team->link }}">
									@if($team->photo) <img src="{{ url($team->photo) }}" alt=""> @endif
									<h4>{{ $team->full_name }}</h4>
									<p>{{ $team->job_title }}</p>
									<i class="fa fa-linkedin details_user_in"></i>
								</a>
							</li>
						@endforeach
					</ul>
               
                </div>

                <div class="col-md-4 col-sm-4">
					<div class="icodetails_bg">
						<h3 class="icodetails_name">{{trans('ico/display.ICO_Details')}}</h3>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Status')}} </div>
							<div class="ico_details_2">{{ $ico->status }} </div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.ICO_Start_date')}} </div>
							<div class="ico_details_2">{{ isset($ico->ico_start_at)?\Carbon\Carbon::parse($ico->ico_start_at)->toFormattedDateString():'TBD' }}</div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.ICO_End_date')}}  </div>
							<div class="ico_details_2"> {{ isset($ico->ico_end_at)?\Carbon\Carbon::parse($ico->ico_end_at)->toFormattedDateString():'TBD' }}</div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Whitelist')}}  </div>
							<div class="ico_details_2"> {{ ucfirst($ico->whitelist) }} </div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Token_Sale_Hard_Cap')}} </div>
							<div class="ico_details_2">
								@if($ico->token_sale_soft_cap)
									{{ $ico->token_sale_hard_cap_currency }} {{ number_format($ico->token_sale_hard_cap) }}
								@else
									{{trans('ico/display.TBD')}}
								@endif
							</div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Token_Sale_Soft_Cap')}} </div>
							<div class="ico_details_2">
								@if($ico->token_sale_soft_cap)
									{{ $ico->token_sale_soft_cap_currency }} {{ number_format($ico->token_sale_soft_cap) }}
								@else
									TBD
								@endif
							</div>
						</div>
						@if($ico->presale == 'yes')
							<div class="ico_details_margin">
								<div class="ico_details_1">{{trans('ico/display.Presale_Start_Date')}} </div>
								<div class="ico_details_2">{{ isset($ico->presale_start_at)?\Carbon\Carbon::parse($ico->presale_start_at)->toFormattedDateString():'TBD' }}</div>
							</div>
							<div class="ico_details_margin">
								<div class="ico_details_1">{{trans('ico/display.Presale_End_Date')}} </div>
								<div class="ico_details_2">{{ isset($ico->presale_end_at)?\Carbon\Carbon::parse($ico->presale_end_at)->toFormattedDateString():'TBD' }}</div>
							</div>
						@endif

						@if($ico->token_symbol)
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Token_Symbol')}} </div>
							<div class="ico_details_2"> {{ $ico->token_symbol }} </div>
						</div>
						@endif
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Token_Type')}}  </div>
							<div class="ico_details_2"> {{ $ico->token_type_and_platform }}  </div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Token_Distribution')}} </div>
							<div class="ico_details_2">
								{!! nl2br($ico->token_distribution) !!}
							</div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.Initial_Token_Price')}}  </div>
							<div class="ico_details_2">{{ $ico->price_per_token }}</div>
						</div>
						<div class="ico_details_margin">
							<div class="ico_details_1">{{trans('ico/display.KYC')}} </div>
							<div class="ico_details_2">{{ ucfirst($ico->kyc) }} </div>
						</div>
						@if($ico->participation_restriction)
							<div class="ico_details_margin">
								<div class="ico_details_1">{{trans('ico/display.Participation_Restrictions')}}</div>
								<div class="ico_details_2">{{ $ico->participation_restriction }} </div>
							</div>
						@endif
						@if($ico->accept_coin)
							<div class="ico_details_margin">
								<div class="ico_details_1">{{trans('ico/display.Accepts')}}  </div>
								<div class="ico_details_2">{{ $ico->accept_coin }}  </div>
							</div>
						@endif
					</div>
                </div>
            </div>
        </div>
    


    </div>
</section>
<!--ico list-->  


@endsection
