@extends('admin.layouts.master')
@section('page-bar')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('admin/ico/edit.Home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('admin/ico/edit.Modify_Ico')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{trans('admin/ico/edit.ICO')}}
        <small>{{trans('admin/ico/edit.Management')}}</small>
    </h1>
    <!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/ico/edit.Manage_ICO')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <form role="form" name="submit-ico" method="post" action="{{ route('admin.ico.update', $ico->slug) }}" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="title">{{trans('admin/ico/edit.Title')}} *</label>
                            <input name="title" class="form-control" type="text" value="{{ $ico->title }}">
                            <p class="help-block"></p>
                        </div>
                        <fieldset>
                            <legend>{{trans('admin/ico/edit.Overview')}}</legend>
                            <div class="form-group">@php $selected_cat= explode(",",$ico->category); @endphp
                                <label class="control-label">{{trans('admin/ico/edit.Category')}}</label>
                                <select data-style="btn-default" data-live-search="true" class="selectpicker form-control"  multiple data-max-options="5" name="category[]">
                                    <option value="">{{trans('admin/ico/edit.Choose_ICO_Type')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ (in_array($category, $selected_cat))?"selected":"" }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
								
                                <label for="logo">{{trans('admin/ico/edit.Logo')}} * <small>({{trans('admin/ico/edit.JPG_or_PNG_file_size_between')}})</small></label>
                                <input type="file" name="logo" class="file" accept="image/*">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                    <input type="text" class="form-control input-md" disabled placeholder="{{trans('admin/ico/edit.Upload_Image')}}">
                                      <span class="input-group-btn">
                                        <button class="browse btn btn-primary input-md" type="button"><i class="glyphicon glyphicon-search"></i> {{trans('admin/ico/edit.Browse')}}</button>
                                      </span>
                                     
                                </div>
                                <p class="help-block"></p>
                                <img src="{{ url($ico->logo) }}" style="height: 70px; width: 70px;">
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Short_Description')}} * <small>{{trans('admin/ico/edit.Describe_the_project_one_sentence')}}</small></label>
                                <textarea name="short_description" class="form-control" rows="5">{{ $ico->short_description }}</textarea>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.ICO_Start_Date')}} <small>{{trans('admin/ico/edit.Donot_enter_Presale_Date')}}</small></label>
                                <input type="text" name="start_date" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($ico->ico_start_at)->toDateString() }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.ICO_End_Date')}}</label>
                                <input type="text" name="end_date" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($ico->ico_end_at)->toDateString() }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Additional_Notes')}}</label>
                                <input type="text" name="ad_notes" class="form-control" value="{{ $ico->additional_notes }}">
                                <p class="help-block"></p>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Links</legend>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Website_Link')}} *</label>
                                <input type="url" name="link[website]" class="form-control" value="{{ $ico->link->website }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Whitepaper_Link')}} *</label>
                                <input type="url" name="link[whitepaper]" class="form-control" value="{{ $ico->link->whitepaper }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Twitter_Link')}}</label>
                                <input type="url" name="link[twitter]" class="form-control" value="{{ $ico->link->twitter }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Slack_Link')}}</label>
                                <input type="url" name="link[slack]" class="form-control" value="{{ $ico->link->slack }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Telegram_Link')}} *</label>
                                <input type="url" name="link[telegram]" class="form-control" value="{{ $ico->link->telegram }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Facebook_Link')}}</label>
                                <input type="url" name="link[facebook]" class="form-control" value="{{ $ico->link->facebook }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Reddit_Link')}}</label>
                                <input type="url" name="link[reddit]" class="form-control" value="{{ $ico->link->reddit }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Bitcointalk_Link')}}</label>
                                <input type="url" name="link[bitcointalk]" class="form-control" value="{{ $ico->link->bitcointalk }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Medium_Link')}}</label>
                                <input type="url" name="link[medium]" class="form-control" value="{{ $ico->link->medium }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Github_Link')}}</label>
                                <input type="url" name="link[github]" class="form-control" value="{{ $ico->link->github }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Discord_App_Link')}}</label>
                                <input type="url" name="link[discord]" class="form-control" value="{{ $ico->link->discord }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group form-md-radios">
                                <label>{{trans('admin/ico/edit.Airdrop')}}</label>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="airdrop_yes" name="airdrop" class="md-radiobtn" value="yes" @if($ico->airdrop == 'yes') checked @endif>
                                        <label for="airdrop_yes">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.Yes')}}
                                        </label>
                                    </div>
                                    <div class="md-radio has-error">
                                        <input type="radio" id="airdrop_no" name="airdrop" class="md-radiobtn" value="no" @if($ico->airdrop == 'no') checked @endif>
                                        <label for="airdrop_no">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.No')}}
                                        </label>
                                    </div>
                                </div>
                                <p class="help-block"></p>
                            </div>
                            @if($ico->airdrop == 'yes')
                                <div class="form-group">
                                    <label for="">{{trans('admin/ico/edit.Airdrop_Link')}}</label>
                                    <input type="url" class="form-control" name="link[airdrop]" value="{{ $ico->link->airdrop }}">
                                    <p class="help-block"></p>
                                </div>
                            @endif
                        </fieldset>
                        <fieldset>
                            <legend>{{trans('admin/ico/edit.Project_Details')}}</legend>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Features')}} * <small>{{trans('admin/ico/edit.More_info_about_the_project')}}</small></label>
                                <textarea name="features" class="form-control" rows="8">{{ $ico->feature_description }}</textarea>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{trans('admin/ico/edit.Offical_Video')}} <small>{{trans('admin/ico/edit.Link_to_official_video')}}</small></label>
                                <input type="url" name="link[video]" class="form-control" value="{{ $ico->link->video }}">
                                <p class="help-block"></p>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{trans('admin/ico/edit.ICO_Details')}}</legend>
                            <div class="form-group form-md-radios">
                                <label>{{trans('admin/ico/edit.Whitelist')}}</label>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="whitelist_yes" name="whitelist" class="md-radiobtn" @if($ico->whitelist == 'yes') checked @endif value="yes">
                                        <label for="whitelist_yes">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.Yes')}}
                                        </label>
                                    </div>
                                    <div class="md-radio has-error">
                                        <input type="radio" id="whitelist_no" name="whitelist" class="md-radiobtn" @if($ico->whitelist == 'no') checked @endif value="no">
                                        <label for="whitelist_no">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.No')}}
                                        </label>
                                    </div>
                                    <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="">{{trans('admin/ico/edit.Token_Sale_Hard_Cap')}} <small>({{trans('admin/ico/edit.Max_Fund_Raising_Goal')}})</small></label>
                                        <input type="text" class="form-control" name="hard_cap" value="{{ $ico->token_sale_hard_cap }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>{{trans('admin/ico/edit.Token_Sale_Hard_Cap_Currency')}}</label>
                                        <select name="hard_cap_cur" class="form-control">
                                            @php $c = $ico->token_sale_hard_cap_currency; @endphp
                                            <option value="USD" @if($c == 'USD') selected @endif>USD</option>
                                            <option value="BTC" @if($c == 'BTC') selected @endif>BTC</option>
                                            <option value="ETH" @if($c == 'ETH') selected @endif>ETH</option>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="">{{trans('admin/ico/edit.Token_Sale_Soft_Cap')}} <small>({{trans('admin/ico/edit.Minimum_amount_required_for_the_project')}})</small></label>
                                        <input type="text" class="form-control" name="soft_cap" value="{{ $ico->token_sale_soft_cap }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>{{trans('admin/ico/edit.Token_Sale_Soft_Cap_Currency')}}</label>
                                        <select name="soft_cap_cur" class="form-control">
                                            @php $c = $ico->token_sale_soft_cap_currency; @endphp
                                            <option value="USD" @if($c == 'USD') selected @endif>USD</option>
                                            <option value="BTC" @if($c == 'BTC') selected @endif>BTC</option>
                                            <option value="ETH" @if($c == 'ETH') selected @endif>ETH</option>
                                        </select>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="">{{trans('admin/ico/edit.Presale')}}</label>
                                <select name="presale" class="form-control">
                                    @php $c = $ico->presale; @endphp
                                    <option value="no" @if($c == 'no') selected @endif>{{trans('admin/ico/edit.No')}}</option>
                                    <option value="yes" @if($c == 'yes') selected @endif>{{trans('admin/ico/edit.Yes')}}</option>
                                    <option value="tbd" @if($c == 'tbd') selected @endif>{{trans('admin/ico/edit.TBD')}}</option>
                                </select>
                                <p class="help-block"></p>
                            </div>
                            @if($c == 'yes')
                                <div class="form-group">
                                    <label for="">{{trans('admin/ico/edit.Presale_Start_Date')}}</label>
                                    <input type="text" class="form-control datepicker" name="presale_start_date" value="{{ $ico->presale_start_at }}">
                                    <p class="help-block"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">{{trans('admin/ico/edit.Presale_End_Date')}}</label>
                                    <input type="text" class="form-control datepicker" name="presale_end_date" value="{{ $ico->presale_end_at }}">
                                    <p class="help-block"></p>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Token_Symbol')}}</label>
                                <input type="text" class="form-control" name="token_symbol" value="{{ $ico->token_symbol }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Token_Type_Platform')}} <span>({{trans('admin/ico/edit.Token_Type_Platform')}})</span></label>
                                <input type="text" class="form-control" name="token_type_platform" value="{{ $ico->token_type_and_platform }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Token_Distribution')}}</label>
                                <textarea type="text" class="form-control" name="token_distribution">{{ $ico->token_distribution }}</textarea>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Price_Per_Token')}} <small>{{trans('admin/ico/edit.Example_token')}}</small></label>
                                <input type="text" class="form-control" name="price_per_token" value="{{ $ico->price_per_token }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group form-md-radios">
                                <label>{{trans('admin/ico/edit.Know_Your_Customer')}}</label>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="kyc_yes" name="kyc" class="md-radiobtn" @if($ico->kyc == 'yes') checked @endif value="yes">
                                        <label for="kyc_yes">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.Yes')}}
                                        </label>
                                    </div>
                                    <div class="md-radio has-error">
                                        <input type="radio" id="kyc_no" name="kyc" class="md-radiobtn" @if($ico->kyc == 'no') checked @endif value="no">
                                        <label for="kyc_no">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.No')}}
                                        </label>
                                    </div>
                                </div>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Participation_Restrictions')}} <small>{{trans('admin/ico/edit.restrictions_participate_ICO')}}</small></label>
                                <input type="text" class="form-control" name="participation_restriction" value="{{ $ico->participation_restriction }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label>{{trans('admin/ico/edit.Selling_to_US_and_or_Canada')}} <small>{{trans('admin/ico/edit.Please_tick_this_box')}}</small></label>
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.We_intend_to_sell_to_residents')}}
                                        <input type="checkbox" name="selling_to_us_canada" value="1"  @if($ico->selling_to_us_canada == 1) checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Accepts')}} <small>{{trans('admin/ico/edit.Example_coin')}}</small></label>
                                <input type="text" class="form-control" name="accept_currency" value="{{ $ico->accept_coin }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Exchange_Listing')}} <small>{{trans('admin/ico/edit.Which_Exchange_have_intend_on_listing_this_project')}}</small></label>
                                <input type="text" class="form-control" name="exchange_listing" value="{{ $ico->listing_exchange }}">
                                <p class="help-block"></p>
                            </div>
                        </fieldset>
                        <fieldset name="team">
                            <legend>{{trans('admin/ico/edit.Team')}}</legend>

                            <div class="col-md-12">
                                <div class="col-md-12"><label class="text-left">{{trans('admin/ico/edit.CoreTeam')}}</label></div>
                                <p class="cmessage"></p>
                                @php $teams = $ico->team()->core()->get(); @endphp

                                @foreach($teams as $team)
                                    <div class="group_core_member">
                                        <input type="hidden" name="core[{{$loop->index}}][team]" value="{{ $team->id }}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">{{trans('admin/ico/edit.Photo')}}</label>
                                                <input type="file" name="core[{{$loop->index}}][photo]" class="file" accept="image/*">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                    <input type="text" class="form-control input-md" disabled placeholder="{{trans('admin/ico/edit.Upload_Image')}}">
                                                  <span class="input-group-btn">
                                                    <button class="browse btn btn-primary input-md" type="button"><i class="glyphicon glyphicon-search"></i> {{trans('admin/ico/edit.Browse')}}</button>
                                                  </span>
                                                </div>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{trans('admin/ico/edit.FullName')}}</label>
                                                <input type="text" class="form-control" name="core[{{$loop->index}}][full_name]" value="{{ $team->full_name }}">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{trans('admin/ico/edit.Job_Title_Role')}}* <small>{{trans('admin/ico/edit.Example_role')}}</small></label>
                                                <input type="text" class="form-control" name="core[{{$loop->index}}][job_title]" value="{{ $team->job_title }}">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{trans('admin/ico/edit.Link')}} <small>{{trans('admin/ico/edit.Link_Linkedin_anyprofile')}}</small></label>
                                                <input type="text" class="form-control" name="core[{{$loop->index}}][link]" value="{{ $team->link }}">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-md-12 text-right">
                                    <button name="add_member" data-type="core" data-count="{{$teams->count()}}" type="button" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('admin/ico/edit.Member')}}</button>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-12"><label class="text-left">{{trans('admin/ico/edit.Advisory_Team')}}</label></div>
                                <div class="amessage"></div>
                                @php $teams = $ico->team()->advisory()->get(); @endphp

                                @foreach($teams as $team)
                                    <div class="group_advisory_member">
                                        <input type="hidden" name="advisory[{{$loop->index}}][team]" value="{{ $team->id }}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">{{trans('admin/ico/edit.Photo')}}</label>
                                                <input type="file" name="advisory[{{$loop->index}}][photo]" class="file" accept="image/*">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                    <input type="text" class="form-control input-md" disabled placeholder="{{trans('admin/ico/edit.Upload_Image')}}">
                                                  <span class="input-group-btn">
                                                    <button class="browse btn btn-primary input-md" type="button"><i class="glyphicon glyphicon-search"></i>{{trans('admin/ico/edit.Browse')}} </button>
                                                  </span>
                                                </div>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{trans('admin/ico/edit.FullName')}}</label>
                                                <input type="text" class="form-control" name="advisory[{{$loop->index}}][full_name]" value="{{ $team->full_name }}">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{trans('admin/ico/edit.Job_Title_Role')}}* <small>{{trans('admin/ico/edit.Example_role')}}</small></label>
                                                <input type="text" class="form-control" name="advisory[{{$loop->index}}][job_title]" value="{{ $team->job_title }}">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{trans('admin/ico/edit.Link')}} <small>{{trans('admin/ico/edit.Link_Linkedin_anyprofile')}}</small></label>
                                                <input type="text" class="form-control" name="core[{{$loop->index}}][link]" value="{{ $team->link }}">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-12 text-right">
                                    <button name="add_member" data-type="advisory" data-count="{{$teams->count()}}" type="button" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('admin/ico/edit.Member')}}</button>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{trans('admin/ico/edit.Company_Contact_Details')}}</legend>
                            <small>
                                {{trans('admin/ico/edit.Who_should_we_contact_for_additional_information')}}
                            </small>
                            <div class="form-group">
                                <label for="company">{{trans('admin/ico/edit.Company_Name')}} <small>{{trans('admin/ico/edit.Please_indicate_the_official_name_of_the_company')}}</small></label>
                                <input type="text" class="form-control" name="company_name" value="{{ $ico->company_name }}">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="company">{{trans('admin/ico/edit.Company_Information')}} <small>{{trans('admin/ico/edit.Please_indicate_company_details')}}</small></label>
                                <textarea class="form-control" name="company_info">{{ $ico->company_info }}</textarea>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label for="company">{{trans('admin/ico/edit.Your_Full_Name')}} *<small>{{trans('admin/ico/edit.Please_indicate_individual_making_name')}}</small></label>
                                <input type="text" class="form-control" name="contact_person_name" value="{{ $ico->contact_person_name }}">
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label>{{trans('admin/ico/edit.Permissions')}} *</label>
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.statements_authorized_representative')}}
                                        <input type="checkbox" value="I certify that any statements provided in this form are by an authorized representative of this project, and that any public marketing materials are true and correct to the personal knowledge of the submitter." name="permission[0]" {{ $ico->checkJsonExists('permissions', 'I certify that any statements provided in this form are by an authorized representative of this project, and that any public marketing materials are true and correct to the personal knowledge of the submitter.')?'checked':'' }}>
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.project_complies_with_the_laws_and_regulations')}}
                                        <input type="checkbox" value="This project complies with the laws and regulations, specifically dealing with sales of securities, in every country/jurisdiction that it sells." name="permission[1]" {{ $ico->checkJsonExists('permissions', 'This project complies with the laws and regulations, specifically dealing with sales of securities, in every country/jurisdiction that it sells.')?'checked':'' }}>
                                        <span></span>
                                    </label>
                                </div>
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label>{{trans('admin/ico/edit.Your_Involvement_in_this_project')}} * <small>{{trans('admin/ico/edit.Please_describe_your_involvement_with_the_ICO')}}</small></label>
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.Founder_Team_Member')}}
                                        <input type="checkbox" value="Founder/Team Member" name="involvement[0]" {{ $ico->checkJsonExists('involvement', 'Founder/Team Member')?'checked':'' }}>
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.PR_Marketing_Agency')}}
                                        <input type="checkbox" value="PR/Marketing Agency" name="involvement[1]" {{ $ico->checkJsonExists('involvement', 'PR/Marketing Agency')?'checked':'' }}>
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline">{{trans('admin/ico/edit.Representative_of_this_Project_in_any_way')}}
                                        <input type="checkbox" value="I am not a Representative of this Project in any way" name="involvement[2]" {{ $ico->checkJsonExists('involvement', 'I am not a Representative of this Project in any way')?'checked':'' }}>
                                        <span></span>
                                    </label>
                                </div>
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Email_Address')}} *</label>
                                <input type="email" class="form-control" name="contact_person_email" value="{{ $ico->contact_person_email }}">
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.Direct_Telegram_Message')}} <span>{{trans('admin/ico/edit.Please_input_your_telegram_link')}}.</span></label>
                                <input type="text" class="form-control" name="contact_person_telegram" value="{{ $ico->contact_person_telegram }}">
                                <p class="help-block"></p>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>{{trans('admin/ico/edit.Marketing')}}</legend>
                            <small>
                                {{trans('admin/ico/edit.We_review_every_project_that_is_submitted')}}
                            </small>

                            <div class="form-group">
                                <label>{{trans('admin/ico/edit.Marketing_Services')}} * <small>{{trans('admin/ico/edit.Please_Indicate_if_you_would_like_to_purchase_packages')}}</small></label>
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.Exclusive_Email_Campaign')}}
                                        <input type="checkbox" name="marketing[0]" {{ $ico->checkJsonExists('marketing_services', 'Exclusive Email Campaign')?'checked':'' }} value="Exclusive Email Campaign">
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline"> {{trans('admin/ico/edit.Premium_Highlighted_Placement')}}
                                        <input type="checkbox" name="marketing[1]" {{ $ico->checkJsonExists('marketing_services', 'Premium Highlighted Placement')?'checked':'' }} value="Premium Highlighted Placement">
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline">{{trans('admin/ico/edit.ICO_Review')}}
                                        <input type="checkbox" name="marketing[2]" @if($ico->checkJsonExists('marketing_services', 'ICO Review (Video or Article)')) checked @endif value="ICO Review (Video or Article)">
                                        <span></span>
                                    </label>
                                    <label class="mt-checkbox mt-checkbox-outline">{{trans('admin/ico/edit.None_of_the_above')}}
                                        <input type="checkbox" name="marketing[3]" {{ $ico->checkJsonExists('marketing_services', 'None of the above')?'checked':'' }} value="None of the above">
                                        <span></span>
                                    </label>
                                </div>
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group form-md-radios">
                                <label>{{trans('admin/ico/edit.Standard_ListingFee')}} <small>{{trans('admin/ico/edit.Note_The_Standard_Listing_Fee')}}</small></label>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="listing_fee_yes" name="listing_fee" class="md-radiobtn" @if($ico->listing_fee == 'yes') checked @endif value="yes">
                                        <label for="listing_fee_yes">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.Yes')}}
                                        </label>
                                    </div>
                                    <div class="md-radio has-error">
                                        <input type="radio" id="listing_fee_no" name="listing_fee" class="md-radiobtn" @if($ico->listing_fee == 'no') checked @endif value="no">
                                        <label for="listing_fee_no">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{trans('admin/ico/edit.No')}}
                                        </label>
                                    </div>
                                    <div class="md-radio has-info">
                                        <label for="kyc_no">
                                            [ {{trans('admin/ico/edit.listing_fee_for_approved_projects')}} ]
                                        </label>
                                    </div>
                                </div>
                                <p class="help-block"></p>
                            </div>

                            <div class="form-group">
                                <label for="">{{trans('admin/ico/edit.How_did_you_hear_about_us')}} <small>{{trans('admin/ico/edit.Please_indicate_how_you_heard_about_us')}}</small></label>
                                <input type="text" class="form-control" name="hear_about_us" value="{{ $ico->how_you_hear_about_us }}">
                                <p class="help-block"></p>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-default">{{trans('admin/ico/edit.Submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('hotbtc/css/bootstrap-select.min.css') }}">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
    div .form-group .checkbox{padding: 0px 20px;}
    div .form-group .file { visibility: hidden; position: absolute; }
</style>
@endpush
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/hotbtc/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/submit-ico.js') }}?v={{time()}}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
		  $( function() {
			$( ".datepicker" ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
		  });

    });
</script>

@endpush
