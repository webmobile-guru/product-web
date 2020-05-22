@extends('admin.layouts.master')
@section('page-bar')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('admin/ico/display.Home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('admin/ico/display.Display_Ico')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{trans('admin/ico/display.ICO')}}
        <small>{{trans('admin/ico/display.Management')}}</small>
    </h1>
    <!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/ico/display.See_Submited_ICO_Data')}}</span>
                    </div>
                    <div class="actions">
                        <a class="btn red btn-outline sbold" href="{{ route('admin.ico.mark', [$ico->slug, 'hot']) }}"><i class="fa fa-fire"></i> {{ $ico->hasTag('hot')?'Unmark':'Mark' }} {{trans('admin/ico/display.Hot')}}</a>
                        <a class="btn yellow btn-outline sbold" href="{{ route('admin.ico.mark', [$ico->slug, 'top']) }}"><i class="fa fa-fighter-jet"></i> {{ $ico->hasTag('top')?'Unmark':'Mark' }} {{trans('admin/ico/display.Top')}}</a>
                        @if($ico->publish_status == 1)
                            <button class="btn purple btn-outline sbold"><i class="fa fa-file"></i> {{trans('admin/ico/display.Published_on')}} {{ $ico->publish_at->toFormattedDateString() }}</button>
                        @elseif($ico->publish_status == 2)
                            <button class="btn red btn-outline sbold"><i class="fa fa-file"></i> {{trans('admin/ico/display.Rejected')}}</button>
                        @else
                            <button class="btn green btn-outline sbold" data-url="{{ route('admin.ico.approve', $ico->slug) }}" name="approve"><i class="fa fa-check"></i> {{trans('admin/ico/display.Approve')}}</button>
                            <button class="btn red btn-outline sbold" data-url="{{ route('admin.ico.reject', $ico->slug) }}" name="reject"><i class="fa fa-times"></i> {{trans('admin/ico/display.Reject')}}</button>
                        @endif
                    </div>
                </div>
                <div class="portlet-body">
                    <div>
                        <article>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-2">
                                    <img style="width:130px; height:130px; margin:auto;" src="{{ $ico->logo }}" class="attachment-ico_single size-ico_single " alt="{{ $ico->title }} ICO" title="{{trans('admin/ico/display.Uranus_ICO')}}" sizes="(max-width: 300px) 100vw, 300px">
                                </div>
                                <div class="col-xs-12 col-sm-9 col-md-10">
                                    <h3 class="icodetails_name"><span class="title-text">{{ $ico->title }}</span> @if($ico->whitelist == 'yes')<span class="labels"> <span class="whitelist">{{trans('admin/ico/display.Whitelist')}}</span></span> @endif</h3>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="text-justify">{!! nl2br($ico->short_description) !!}</p>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7 ico-fa-links">
                                        <ul class="icodetails_media">
                                                @if($ico->link->twitter)
                                                <li><a target="_blank" href="{{ $ico->link->twitter }}" title="ICO on twitter"><i class="fa fa-twitter"></i></a></li>
                                                @endif
                                                @if($ico->link->facebook)
                                                <li> <a target="_blank" href="{{ $ico->link->facebook }}" title="ICO on facebook"><i class="fa fa-facebook-f"></i></a></li>
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
                                                <li><a target="_blank" href="{{ $ico->link->reddit }}"  title="ICO on discord app"><i class="fa fa-discord"></i></a></li>
                                                @endif
                                                @if($ico->link->github)
                                                <li><a target="_blank" href="{{ $ico->link->github }}"  title="ICO on github"><i class="fa fa-github"></i></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="col-md-5">
                                            <a class="btn btn-primary btn-ICO-whitepaper" href="{{ $ico->link->whitepaper }}" target="_blank">{{trans('admin/ico/display.View_Whitepaper')}}</a>
                                            <a class="btn btn-primary btn-ICO-website" href="{{ $ico->link->website }}" target="_blank">{{trans('admin/ico/display.View_Website')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="ico-single-details row">

                                <div class="col-md-8">
                                    <div class="official-video">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe width="640" height="360" src="{{ $ico->link->video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
                                        </div>
                                    </div>

                                    <h3 class="icodetails_name">{{trans('admin/ico/display.Features')}}</h3>
                                    <p class="text-justify">{!! nl2br($ico->feature_description) !!}</p>
                                    <br>
                                    <h3 class="icodetails_name"> {{trans('admin/ico/display.Core_Team')}}</h3>
                                    <ul class="details_user_ul">
                                        @php $teams = $ico->team()->core()->get(); @endphp
                                        @foreach($teams as $team)
                                        <li>
                                            <a href="{{ $team->link }}" target="_blank">
                                                <img src="{{ $team->photo }}" class="attachment-team_member size-team_member" alt="">
                                                <h4>{{ $team->full_name }}</h4>
                                                <p>{{ $team->job_title }}</p>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <br>
                                    <h3 class="icodetails_name"> {{trans('admin/ico/display.Advisory_Team')}}</h3>
                                    <ul class="details_user_ul">
                                        @php $teams = $ico->team()->advisory()->get(); @endphp
                                            @foreach($teams as $team)
                                        <li>
                                            <a href="{{ $team->link }}" target="_blank">
                                                <img src="{{ $team->photo }}" class="attachment-team_member size-team_member" alt="">
                                                <h4>{{ $team->full_name }}</h4>
                                                <p>{{ $team->job_title }}</p>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>

                                </div>
                                <div class="col-md-4">
                                <div class="icodetails_bg">
                                        <h3 class="icodetails_name">{{trans('admin/ico/display.ICO_Details')}}</h3>

                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Status')}} </div>
                                            <div class="ico_details_2">{{ $ico->status }} </div>
                                        </div>

                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Presale')}} </div>
                                            <div class="ico_details_2">{{ ucfirst($ico->presale) }} </div>
                                        </div>
                                        @if($ico->presale == 'yes')
                                            <div class="ico_details_margin">
                                                <div class="ico_details_1">{{trans('admin/ico/display.Presale_Start_Date')}} </div>
                                                <div class="ico_details_2">{{ isset($ico->presale_start_at)?\Carbon\Carbon::parse($ico->presale_start_at)->toFormattedDateString():'TBD' }}</div>
                                            </div>
                                            <div class="ico_details_margin">
                                                <div class="ico_details_1">{{trans('admin/ico/display.Presale_End_Date')}} </div>
                                                <div class="ico_details_2">{{ isset($ico->presale_end_at)?\Carbon\Carbon::parse($ico->presale_end_at)->toFormattedDateString():'TBD' }}</div>
                                            </div>
                                        @endif
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.ICO_Start_date')}} </div>
                                            <div class="ico_details_2">{{ isset($ico->ico_start_at)?\Carbon\Carbon::parse($ico->ico_start_at)->toFormattedDateString():'TBD' }}</div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.ICO_End_date')}} </div>
                                            <div class="ico_details_2">{{ isset($ico->ico_end_at)?\Carbon\Carbon::parse($ico->ico_end_at)->toFormattedDateString():'TBD' }}</div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Whitelist')}} </div>
                                            <div class="ico_details_2">{{ ucfirst($ico->whitelist) }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Token_Sale_Hard_Cap')}} </div>
                                            <div class="ico_details_2">{{ $ico->token_sale_hard_cap_currency }} {{ $ico->token_sale_hard_cap }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Token_Sale_Soft_Cap')}} </div>
                                            <div class="ico_details_2">{{ $ico->token_sale_soft_cap_currency }} {{ $ico->token_sale_soft_cap }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Token_Symbol')}} </div>
                                            <div class="ico_details_2">{{ $ico->token_symbol }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Token_Type')}} </div>
                                            <div class="ico_details_2">{{ $ico->token_type_and_platform }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Token_Distribution')}} </div>
                                            <div class="ico_details_2">{!! nl2br($ico->token_distribution) !!}</div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Initial_Token_Price')}} </div>
                                            <div class="ico_details_2">{{ $ico->price_per_token }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.KYC')}} </div>
                                            <div class="ico_details_2">{{ ucfirst($ico->kyc) }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Participation_Restrictions')}} </div>
                                            <div class="ico_details_2">{{ $ico->participation_restriction }} </div>
                                        </div>
                                        <div class="ico_details_margin">
                                            <div class="ico_details_1">{{trans('admin/ico/display.Accepts')}} </div>
                                            <div class="ico_details_2">{{ $ico->accept_coin }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('button[name=approve]').click(function () {
            var action = $(this).data('url');
            var csrf = $('meta[name=csrf-token]').attr('content');
            bootbox.confirm("<form id='infos' method='post' action='"+ action +"'>\
            <input type='hidden' name='_token' value='"+csrf+"'>\
                Publish On:<input type='date' name='publish_on' class='form-control' /><br/>\
                Remarks:<input type='text' name='remarks' class='form-control' />\
                </form>", function(result) {
                if(result)
                    $('#infos').submit();
            });
        });

        $('button[name=reject]').click(function () {
            var action = $(this).data('url');
            var csrf = $('meta[name=csrf-token]').attr('content');
            bootbox.confirm("<form id='infos' method='post' action='"+ action +"'>\
            <input type='hidden' name='_token' value='"+csrf+"'>\
                Reason of rejection:<input type='text' name='remarks' class='form-control' />\
                </form>", function(result) {
                if(result)
                    $('#infos').submit();
            });
        });
    });
</script>
@endpush
