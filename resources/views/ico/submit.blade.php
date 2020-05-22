@extends('front.user')
@section('content')
@guest
    @include('front.layout.guest-header')
@else
    @include('front.layout.user-header')
@endguest
<section class="sm_padding">
<div class="container">
    <div class="card_shadow">
        @include('flash::message')
        <div class="sm_heading">
			<h2>{{trans('ico/submit.Apply_To_List_ICO')}}</h2>
		</div>
        <form name="submit-ico" method="post" action="{{ route('ico.submit.process') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="title" class="required">{{trans('ico/submit.Title')}}</label>
                        <input name="title" class="form-control" type="text" value="{{ old('title') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="start_date" class="">{{trans('ico/submit.ICO_Start_Date')}} <small>({{trans('ico/submit.Donot_enter_Presale_Date')}})</small></label>
                        <input type="text" name="start_date" class="form-control datepicker" value="{{ old('start_date') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="end_date" class="">{{trans('ico/submit.ICO_End_Date')}}</label>
                        <input type="text" name="end_date" class="form-control datepicker"  value="{{ old('end_date') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group category_group">
                        <label class="control-label required">{{trans('ico/submit.Category')}}</label>
                        <select data-style="btn-default" data-live-search="true" class="selectpicker form-control"  multiple data-max-options="5" name="category[]">
                            <option value="">{{trans('ico/submit.Choose_ICO_Type')}}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="logo" class="required">{{trans('ico/submit.Logo')}} <small>({{trans('ico/submit.JPG_PNG_file')}})</small></label>
                        <input type="file" name="logo" class="file" accept="image/*" onchange="validate(this)">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-image"></i></span>
                            <input type="text" class="form-control input-md" disabled placeholder="{{trans('ico/submit.Upload_Image')}}">
                            <span class="input-group-btn">
                                <button class="browse btn btn-primary input-md" type="button"><i class="fa fa-search"></i> {{trans('ico/submit.Browse')}}</button>
                            </span>
                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Additional_Notes')}}</label>
                        <input type="text" name="ad_notes" class="form-control"  value="{{ old('ad_notes') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="logo" class="required">{{trans('ico/submit.Short_Description')}} <small>{{trans('ico/submit.Describe_the_project')}}</small></label>
                        <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <h3>{{trans('ico/submit.Links')}}</h3>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo" class="required">{{trans('ico/submit.Website_Link')}}</label>
                        <input type="url" name="link[website]" class="form-control" value="{{ old('link.website') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo" class="required">{{trans('ico/submit.Whitepaper_Link')}}</label>
                        <input type="url" name="link[whitepaper]" class="form-control" value="{{ old('link.whitepaper') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo" class="required">{{trans('ico/submit.Telegram_Link')}}</label>
                        <input type="url" name="link[telegram]" class="form-control" value="{{ old('link.telegram') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Slack_Link')}}</label>
                        <input type="url" name="link[slack]" class="form-control" value="{{ old('link.slack') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Twitter_Link')}}</label>
                        <input type="url" name="link[twitter]" class="form-control" value="{{ old('link.twitter') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Facebook_Link')}}</label>
                        <input type="url" name="link[facebook]" class="form-control" value="{{ old('link.facebook') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Reddit_Link')}}</label>
                        <input type="url" name="link[reddit]" class="form-control" value="{{ old('link.reddit') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Bitcointalk_Link')}}</label>
                        <input type="url" name="link[bitcointalk]" class="form-control" value="{{ old('link.bitcointalk') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Medium_Link')}}</label>
                        <input type="url" name="link[medium]" class="form-control" value="{{ old('link.medium') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Github_Link')}}</label>
                        <input type="url" name="link[github]" class="form-control" value="{{ old('link.github') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Discord_App_Link')}}</label>
                        <input type="url" name="link[discord]" class="form-control" value="{{ old('link.discord') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
<!--
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="logo">Discord App Link</label>
                        <input type="url" name="link[discord]" class="form-control" value="{{ old('link.discord') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
-->
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Airdrop')}}</label>
                        <div class="checkbox">
                            <label><input type="radio" name="airdrop" value="yes" @if(old('airdrop') == 'yes') checked @endif> {{trans('ico/submit.Yes')}} <input name="airdrop" type="radio" value="no" @if(old('airdrop') == 'no') checked @endif> {{trans('ico/submit.No')}}</label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <h3>{{trans('ico/submit.Project_Details')}}</h3>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="logo" class="required">{{trans('ico/submit.Features')}} <small>({{trans('ico/submit.More_info_about_the_project')}})</small></label>
                        <textarea name="features" class="form-control">{{ old('features') }}</textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="logo">{{trans('ico/submit.Offical_Video')}} <small>({{trans('ico/submit.Embed_Url_of_official_video')}})</small></label>
                        <input type="url" name="link[video]" class="form-control" value="{{ old('link.video') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <h3>{{trans('ico/submit.ICO_Details')}}</h3>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Whitelist')}}</label>
                        <div class="checkbox">
                            <label><input type="radio" name="whitelist" value="yes" @if(old('whitelist') == 'yes') checked @endif> {{trans('ico/submit.Yes')}} <input name="whitelist" type="radio" value="no" @if(old('whitelist') == 'no') checked @endif> {{trans('ico/submit.No')}}</label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Token_Sale_Hard_Cap')}} <small>({{trans('ico/submit.Max_Fund_Raising_Goal')}})</small></label>
                        <input type="text" class="form-control" name="hard_cap" value="{{ old('hard_cap') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label>{{trans('ico/submit.Token_Sale_Hard_Cap_Currency')}}</label>
                        <select name="hard_cap_cur" class="form-control">
                            <option value="USD" {{ (old('hard_cap_cur') == 'USD')?'selected':'' }}>USD</option>
                            <option value="BTC" {{ (old('hard_cap_cur') == 'BTC')?'selected':'' }}>BTC</option>
                            <option value="ETH" {{ (old('hard_cap_cur') == 'ETH')?'selected':'' }}>ETH</option>
                        </select>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans("ico/submit.Token_Sale_Soft_Cap")}} <small>({{trans("ico/submit.Minimum_amount_required_for_the_project")}})</small></label>
                        <input type="text" class="form-control" name="soft_cap" value="{{ old('soft_cap') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>{{trans('ico/submit.Token_Sale_Soft_Cap_Currency')}}</label>
                        <select name="soft_cap_cur" class="form-control">
                            <option value="USD" {{ (old('soft_cap_cur') == 'USD')?'selected':'' }}>USD</option>
                            <option value="BTC" {{ (old('soft_cap_cur') == 'BTC')?'selected':'' }}>BTC</option>
                            <option value="ETH" {{ (old('soft_cap_cur') == 'ETH')?'selected':'' }}>ETH</option>
                        </select>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="control-label">{{trans("ico/submit.Presale")}}</label>
                        <select name="presale" class="form-control">
                            <option value="no" {{ (old('presale') == 'no')?'selected':'' }}>{{trans("ico/submit.No")}}</option>
                            <option value="yes" {{ (old('presale') == 'yes')?'selected':'' }}>{{trans("ico/submit.Yes")}}</option>
                            <option value="tbd" {{ (old('presale') == 'tbd')?'selected':'' }}>{{trans("ico/submit.TBD")}}</option>
                        </select>
                        <p class="help-block"></p>
                    </div>

                    @if(old('presale_start_date') || old('presale_end_date'))
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="">{{trans('ico/submit.Presale_Start_Date')}}</label>
                                    <input type="text" class="form-control datepicker" name="presale_start_date" value="{{ old('presale_start_date') }}">
                                    <p class="help-block"></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="">{{trans('ico/submit.Presale_End_Date')}}</label>
                                    <input type="text" class="form-control datepicker" name="presale_end_date" value="{{ old('presale_end_date') }}">
                                    <p class="help-block"></p> 
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Token_Symbol')}}</label>
                        <input type="text" class="form-control" name="token_symbol" value="{{ old('token_symbol') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Token_Type_and_Platform')}} <span><small>({{trans('ico/submit.Token_Type_and_Platform')}})</small></span></label>
                        <input type="text" class="form-control" name="token_type_platform" value="{{ old('token_type_platform') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Price_Per_Token')}} <small>({{trans('ico/submit.example_Token')}})</small></label>
                        <input type="text" class="form-control" name="price_per_token" value="{{ old('price_per_token') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Token_Distribution')}}</label>
                        <textarea type="text" class="form-control" name="token_distribution">{{ old('token_distribution') }}</textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Know_Your_Customer')}}</label>
                        <div class="checkbox">
                            <label>
                                <input type="radio" name="kyc" value="yes" {{ (old('presale') == 'yes')?'checked':'' }}> {{trans("ico/submit.Yes")}}
                                <input type="radio" name="kyc" value="no" {{ (old('presale') == 'no')?'checked':'' }}> {{trans("ico/submit.No")}}
                            </label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans("ico/submit.Participation_Restrictions")}} <small>({{trans("ico/submit.restrictions_to_participate_in_this_ICO")}})</small></label>
                        <input type="text" class="form-control" name="participation_restriction" value="{{ old('participation_restriction') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Accepts')}} <small>({{trans('ico/submit.coin_example')}})</small></label>
                        <input type="text" class="form-control" name="accept_currency" value="{{ old('accept_currency') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans('ico/submit.Selling_to_US_and_or_Canada')}} <small>({{trans('ico/submit.Please_tick_this_box')}})</small></label>
                        <div class="checkbox">
                            <label><input type="checkbox" name="selling_to_us_canada" value="1" {{ (old('selling_to_us_canada') == '1')?'checked':'' }}> {{trans("ico/submit.Yes_we_intend_to_sell")}}</label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">{{trans("ico/submit.Exchange_Listing")}} <small>({{trans("ico/submit.Which_Exchange_have_on_listing")}})</small></label>
                        <input type="text" class="form-control" name="exchange_listing" value="{{ old('exchange_listing') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <h3>{{trans('ico/submit.Team')}}</h3>
            <fieldset name="team">
                <div class="row">
                    <div class="col-md-12"><label class="text-left required">{{trans('ico/submit.Core_Team')}}</label></div>
                    <p class="cmessage text-danger"></p>
                    @php $count = old('core')?count(old('core')): 0 @endphp
                    @if($count)
                        @for($i = 0; $i<$count ; $i++)
                            <div class="group_core_member">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{trans('ico/submit.Photo')}}</label>
                                        <input type="file" class="file" name="core[{{ $i }}][photo]" accept="image/*" onchange="validate(this)">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-image"></i></span>
                                            <input type="text" class="form-control input-md" disabled placeholder="{{trans('ico/submit.Upload_Image')}}">
                                    <span class="input-group-btn">
                                        <button class="browse btn btn-primary input-md" type="button"><i class="fa fa-search"></i> {{trans('ico/submit.Browse')}}</button>
                                    </span>
                                        </div>

                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">{{trans('ico/submit.FullName')}}</label>
                                        <input type="text" class="form-control" name="core[{{ $i }}][full_name]" value="{{ old('core.'.$i.'.full_name') }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="job_title" class="required">{{trans('ico/submit.Job_Title_Role')}} <small>{{trans('ico/submit.Job_example')}}</small></label>
                                        <input type="text" class="form-control" name="core[{{ $i }}][job_title]" value="{{ old('core.'.$i.'.job_title') }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{trans('ico/submit.Link')}} <small>{{trans('ico/submit.Link_to_Linkedin')}}</small></label>
                                        <input type="text" class="form-control" name="core[{{ $i }}][link]" value="{{ old('core.'.$i.'.link') }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endif
                    <div class="col-md-12 text-right">
                        <button name="add_member" data-type="core" data-count="{{ $count }}" type="button" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('ico/submit.Member')}}</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><label class="text-left">{{trans('ico/submit.Advisory_Team')}}</label></div>
                    <div class="amessage"></div>
                    @php $count = old('advisory')?count(old('advisory')): 0 @endphp
                    @if($count)
                        @for($i = 0; $i<$count ; $i++)
                            <div class="group_advisory_member">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{trans('ico/submit.Photo')}}</label>
                                        <input type="file" class="file" name="advisory[{{ $i }}][photo]" accept="image/*" onchange="validate(this)">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-image"></i></span>
                                            <input type="text" class="form-control input-md" disabled placeholder="{{trans('ico/submit.Upload_Image')}}">
                                    <span class="input-group-btn">
                                        <button class="browse btn btn-primary input-md" type="button"><i class="fa fa-search"></i> {{trans('ico/submit.Browse')}}</button>
                                    </span>
                                        </div>
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{trans('ico/submit.FullName')}}</label>
                                        <input type="text" class="form-control" name="advisory[{{ $i }}][full_name]" value="{{ old('advisory.'.$i.'.full_name') }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="required">{{trans('ico/submit.Job_Title_Role')}} <small>{{trans('ico/submit.Job_example')}}</small></label>
                                        <input type="text" class="form-control" name="advisory[{{ $i }}][job_title]" value="{{ old('advisory.'.$i.'.job_title') }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{trans('ico/submit.Link')}} <small>{{trans('ico/submit.Link_to_Linkedin')}}</small></label>
                                        <input type="text" class="form-control" name="advisory[{{ $i }}][link]" value="{{ old('advisory.'.$i.'.link') }}">
                                        <p class="help-block"></p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endif
                    <div class="col-md-12 text-right">
                        <button name="add_member" data-type="advisory" data-count="0" type="button" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('ico/submit.Member')}}</button>
                    </div>
                </div>
            </fieldset>
            <h3>{{trans('ico/submit.Company_Contact_Details')}}</h3>
            <small>
               {{trans('ico/submit.contact_for_additional_information')}}
            </small>
            <div class="row">
                <div class="col-md-5 col-sm-6">
                    <div class="form-group">
                        <label for="company">{{trans('ico/submit.Company_Name')}} <small>({{trans('ico/submit.Please_indicate_official_name')}})</small></label>
                        <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-7 col-sm-6">
                    <div class="form-group">
                        <label for="company" class="required">{{trans('ico/submit.Your_Full_Name')}} <small>({{trans('ico/submit.Please_indicate_individual_making_name')}})</small></label>
                        <input type="text" class="form-control" name="contact_person_name"  value="{{ old('contact_person_name') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="company">{{trans('ico/submit.Company_Information')}} <small>({{trans('ico/submit.Please_indicate_the_full_company')}})</small></label>
                <textarea class="form-control" name="company_info">{{ old('company_info') }}</textarea>
                <p class="help-block"></p>
            </div>

            <div class="form-group">
                <label for="" class="required">{{trans('ico/submit.Permissions')}}</label>
                @php  @endphp
                <div class="checkbox">
                    <label><input type="checkbox" name="permission[0]" @if(old('permission.0')) checked @endif value="I certify that any statements provided in this form are by an authorized representative of this project, and that any public marketing materials are true and correct to the personal knowledge of the submitter."> {{trans('ico/submit.certify_that_any_statements_provided')}}</label>
                    <label><input type="checkbox" name="permission[1]" @if(old('permission.1')) checked @endif value="This project complies with the laws and regulations, specifically dealing with sales of securities, in every country/jurisdiction that it sells.">{{trans('ico/submit.project_complies_with_the_laws')}}</label>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="" class="required">{{trans('ico/submit.Your_Involvement_in_this_project')}} <small>({{trans('ico/submit.Please_describe_your_involvement')}})</small></label>
                <div class="checkbox">
                    <label><input type="checkbox" name="involvement[0]" @if(old('involvement.0')) checked @endif value="Founder/Team Member"> {{trans('ico/submit.Founder_Team_Member')}}</label>
                    <label><input type="checkbox" name="involvement[1]" @if(old('involvement.1')) checked @endif value="PR/Marketing Agency"> {{trans('ico/submit.PR_Marketing_Agency')}}</label>
                    <label><input type="checkbox" name="involvement[2]" @if(old('involvement.2')) checked @endif value="I am not a Representative of this Project in any way"> {{trans('ico/submit.not_a_Representative')}}</label>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="row">
                <div class="col-md-5 col-sm-6">
                    <div class="form-group">
                        <label for="" class="required">{{trans('ico/submit.Email_Address')}}</label>
                        <input type="email" class="form-control" name="contact_person_email" value="{{ old('contact_person_email') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-md-7 col-sm-6">
                    <div class="form-group">
                        <label for="" >{{trans('ico/submit.Direct_Telegram_Message')}} <span>({{trans('ico/submit.Please_input_your_telegram_link')}})</span></label>
                        <input type="url" class="form-control" name="contact_person_telegram"  value="{{ old('contact_person_telegram') }}">
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>

            <h3>{{trans('ico/submit.Marketing')}}</h3>
            <small>
               {{trans('ico/submit.We_review_every_project')}}
            </small>
            <div class="form-group">
                <label for="" class="required">{{trans('ico/submit.Marketing_Services')}} <small>({{trans('ico/submit.Please_Indicate_if_you_would_like_to_purchase')}}).</small></label>
                <div class="checkbox">
                    <label><input type="checkbox" name="marketing[0]" @if(old('marketing.0')) checked @endif value="Exclusive Email Campaign"> {{trans('ico/submit.Exclusive_Email_Campaign')}}</label>
                    <label><input type="checkbox" name="marketing[1]" @if(old('marketing.1')) checked @endif value="Premium Highlighted Placement"> {{trans('ico/submit.Premium_Highlighted_Placement')}}</label>
                    <label><input type="checkbox" name="marketing[2]" @if(old('marketing.2')) checked @endif value="ICO Review (Video or Article)"> {{trans('ico/submit.ICO_Review')}}</label>
                    <label><input type="checkbox" name="marketing[3]" @if(old('marketing.3')) checked @endif value="None of the above"> {{trans('ico/submit.None_of_the_above')}}</label>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="listing_fee" class="required">{{trans('ico/submit.Standard_Listing_Fee')}}</label>
                <small>({{trans('ico/submit.Note_Standard_Listing_Fee')}})</small>
                <div class="checkbox">
                    <label><input type="radio" name="listing_fee" value="1" @if(old('listing_fee') == "1") checked @endif> {{trans('ico/submit.Yes_I_understand')}}</label>
                    <label><input type="radio" name="listing_fee" value="0" @if(old('listing_fee') == "0") checked @endif> {{trans('ico/submit.No_I_understand')}}.</label>
                </div>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label for="">{{trans('ico/submit.How_did_you_hear_aboutus')}} <small>({{trans('ico/submit.Please_indicate_how_you_heard_aboutus')}})</small></label>
                <input type="text" class="form-control" name="hear_about_us" value="{{ old('hear_about_us') }}">
                <p class="help-block"></p>
            </div>
            <div class="form-group" style="overflow: hidden;">
				<div class="row">
					<div class="col-md-2 col-sm-3">
						<img class="img-responsive" src="<?php echo $builder->inline(); ?>" />
					</div>
					<div class="col-md-3 col-sm-9">
						<input style="padding-left: 10px;" type="text" name="captcha" class="form-control" placeholder="{{trans('ico/submit.Enter_what_you_see')}}">
						@if ($errors->has('captcha'))
							<span class="text-danger">
								<strong>{{ $errors->first('captcha') }}</strong>
							</span>
						@endif
					</div>
					 <p class="help-block"></p>
				</div>
            </div>
            
            
            
			
				
				
            <button type="submit" class="sidenav_btn">{{trans('ico/submit.Submit')}}</button>
        </form>
    </div>
    </div>
</section>
@endsection

@push('css')
<style type="text/css">
    small { color: #1894ddb5; }
    div .form-group .file { visibility: hidden; position: absolute; }
    .help-block { height: 10px;}
</style>
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('js/submit-ico.js') }}?v={{time()}}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $( function() {
      $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
      });
    } );
</script>
@endpush
