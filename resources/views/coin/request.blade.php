@extends('front.user')
@section('content')
    @guest
        @include('front.layout.guest-header')
    @else
        @include('front.layout.user-header')
    @endguest
        <section class="all_padding">
            {{--<div class="jumbotron">--}}
                <div class="container">
                    <div class="coin_list_section card_shadow">
                        <div class="sm_heading">
                            <h2>{{trans('coin/request.Apply_To_List_Coin_Token')}} </h2>
                        </div>
                        @include('flash::message')
                        <form name="submit-ico" method="post" action="{{ route('request.coin.post') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('email_address')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Email_Address')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Enter_your_email_to_contact')}}" name="email_address" value="{{ old('email_address') }}">
                                    @if($errors->has('email_address'))
                                        <span class="help-block">{{ $errors->first('email_address') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('full_name')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_your_fullname')}}<span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="full_name" value="{{ old('full_name') }}">
                                    @if($errors->has('full_name'))
                                        <span class="help-block">{{ $errors->first('full_name') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('name_of_company')?' has-error':'' }}">
                                        <label>{{trans('coin/request.Please_provide_Company_name')}}.<span class="text-danger">*</span></label>
                                        <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="name_of_company" value="{{ old('name_of_company') }}">
                                        @if($errors->has('name_of_company'))
                                            <span class="help-block">{{ $errors->first('name_of_company') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('position_in_company.2')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_confirm_your_position')}}<span class="text-danger">*</span></label>
                                    <br>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="pos_comp" name="position_in_company[0]" value="CEO" @if(old('position_in_company.0') == 'CEO') checked @endif>{{trans('coin/request.CEO')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox"  class="pos_comp" name="position_in_company[1]" value="Founder" @if(old('position_in_company.1') == 'Founder') checked @endif>{{trans('coin/request.Founder')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox"  class="pos_comp" name="position_in_company[2]" onchange="$('input[type=text][name=\'position_in_company[2]\']').toggle()" @if((old('position_in_company.2') != '') && (old('position_in_company.2') != 'Other')) checked @endif>{{trans('coin/request.Other')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <input @if((old('position_in_company.2') == '') || (old('position_in_company.2') == 'Other'))  style="display: none" @endif class="pos_comp_other" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="position_in_company[2]" value="{{ old('position_in_company.2') }}">
                                    </div>
                                    @if($errors->has('position_in_company'))
                                        <span class="help-block">{{ $errors->first('position_in_company') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('one_sentence_pitch')?' has-error':'' }}">
                                    <label>{{trans('coin/request.your_best_onesentence_pitch')}}<span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="one_sentence_pitch" value="{{ old('one_sentence_pitch') }}">
                                    @if($errors->has('one_sentence_pitch'))
                                        <span class="help-block">{{ $errors->first('one_sentence_pitch') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('previously_send')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Have_you_previously_submitted')}}<span class="text-danger">*</span></label>
                                    <div class="checkbox-inline">
                                        <label><input type="radio" name="previously_send" value="yes" @if(old('previously_send') == 'yes') checked @endif>{{trans('coin/request.Yes')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="radio" name="previously_send" value="no" @if(old('previously_send') == 'no') checked @endif>{{trans('coin/request.No')}}</label>
                                    </div>
                                    @if($errors->has('previously_send'))
                                        <span class="help-block">{{ $errors->first('previously_send') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            

                            
                            
                            <h3 {{--style="border-bottom: 1px solid #000; width: 200px;"--}}>{{trans('coin/request.Project_Overview')}}</h3>
                            <hr />

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('project_name')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_the_project_name')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="project_name"  value="{{ old('project_name') }}">
                                    @if($errors->has('project_name'))
                                        <span class="help-block">{{ $errors->first('project_name') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('token_coin_name')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_the_token_coin_name')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" name="token_coin_name" placeholder="{{trans('coin/request.Your_Answer')}}"  value="{{ old('token_coin_name') }}">
                                    @if($errors->has('token_coin_name'))
                                        <span class="help-block">{{ $errors->first('token_coin_name') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('token_coin_symbol')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_the_token_coin_symbol')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="token_coin_symbol"  value="{{ old('token_coin_symbol') }}">
                                    @if($errors->has('token_coin_symbol'))
                                        <span class="help-block">{{ $errors->first('token_coin_symbol') }}</span>
                                    @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('official_website')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_official_website')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="official_website"  value="{{ old('official_website') }}">
                                    @if($errors->has('official_website'))
                                        <span class="help-block">{{ $errors->first('official_website') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('whitepaper_link')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_permanent_link')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="whitepaper_link"  value="{{ old('whitepaper_link') }}">
                                    @if($errors->has('whitepaper_link'))
                                        <span class="help-block">{{ $errors->first('whitepaper_link') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('project_nature.6')?' has-error':'' }}">
                                    <label>{{trans('coin/request.nature_of_the_Project')}} <span class="text-danger">*</span></label>
                                    <br>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[0]" value="Currency" @if(old('project_nature.0') == 'Currency') checked @endif>{{trans('coin/request.Currency')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[1]" value="DApp" @if(old('project_nature.1') == 'DApp') checked @endif>{{trans('coin/request.DApp')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[2]" value="Payments Token" @if(old('project_nature.2') == 'Payments Token') checked @endif>{{trans('coin/request.Payments_Token')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[3]" value="Protocol" @if(old('project_nature.3') == 'Protocol') checked @endif>{{trans('coin/request.Protocol')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[4]" value="Platform" @if(old('project_nature.4') == 'Platform') checked @endif>{{trans('coin/request.Platform')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[5]" value="Stable Coin" @if(old('project_nature.5') == 'Stable Coin') checked @endif>{{trans('coin/request.StableCoin')}}</label>
                                    </div>
                                    <div class="checkbox-inline">
                                        <label><input type="checkbox" class="project_nature" name="project_nature[6]" @if((old('project_nature.6') != '') && (old('project_nature.6') != 'Other'))  checked @endif onchange="$('input[type=text][name=\'project_nature[6]\']').closest('div.form-group').toggle();">{{trans('coin/request.Other')}}</label>
                                    </div>
                                    @if($errors->has('project_nature'))
                                        <span class="help-block">{{ $errors->first('project_nature') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" @if((old('project_nature.6') == '') || (old('project_nature.6') == 'Other'))  style="display: none" @endif>
                                <input class="login_input_text project_nature_other" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="project_nature[6]" value="{{ old('project_nature.6') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('main_application')?' has-error':'' }}">
                                    <label>{{trans('coin/request.the_main_application_Project')}}  <span class="text-danger">*</span></label>
                                    <small>{{trans('coin/request.main_application_example')}}</small>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="main_application" value="{{ old('main_application') }}">
                                    @if($errors->has('main_application'))
                                        <span class="help-block">{{ $errors->first('main_application') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('target_industry')?' has-error':'' }}">
                                    <label>{{trans('coin/request.target_industry_of_the_Project')}} <span class="text-danger">*</span></label>
                                    <small>({{trans('coin/request.target_industry_example')}})</small>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="target_industry" value="{{ old('target_industry') }}">
                                    @if($errors->has('target_industry'))
                                        <span class="help-block">{{ $errors->first('target_industry') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('competetor')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Who_are_the_Project_competitors')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="competetor" value="{{ old('competetor') }}">
                                    @if($errors->has('competetor'))
                                        <span class="help-block">{{ $errors->first('competetor') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group{{ $errors->has('other_info')?' has-error':'' }}">
                                    <label>{{trans('coin/request.Please_provide_any_other_information')}} <span class="text-danger">*</span></label>
                                    <input class="login_input_text form-control" type="text" placeholder="{{trans('coin/request.Your_Answer')}}" name="other_info" value="{{ old('other_info') }}">
                                    @if($errors->has('other_info'))
                                        <span class="help-block">{{ $errors->first('other_info') }}</span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="overflow: hidden;">
								<div class="row">
									<div class="col-md-2 col-sm-3">
										<img class="img-responsive" src="<?php echo $builder->inline(); ?>" />
									</div>
									<div class="col-md-3 col-sm-9">
										<input style="padding-left: 10px;" type="text" name="captcha" class="form-control" placeholder="{{trans('coin/request.Enter_what_you_see')}}">
										@if ($errors->has('captcha'))
											<span class="text-danger">
												<strong>{{ $errors->first('captcha') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>

                            
                            <button type="submit" class="sidenav_btn">{{trans('coin/request.Submit')}}</button>
                        </form>
                    </div>
                </div>
            {{--</div>--}}
        </section>
@endsection

@push('css')
<style type="text/css">
    div .form-group .file { visibility: hidden; position: absolute; }
</style>
@endpush
@push('js')
<script>

// $('.pos_comp').each(function() {
//     var formGroup = $(this).closest('div.form-group');
//     formGroup.addClass('has-error');
//     formGroup.find('p').text('This is a required field');
// });
// $('.project_nature').each(function() {
//     var formGroup = $(this).closest('div.form-group');
//     formGroup.addClass('has-error');
//     formGroup.find('p').text('This is a required field');
// });

$('.pos_comp').change(function() { 
    //$('.pos_comp_other').val($(this).val());
    $('.pos_comp_other').val('Other')  
});

$('.project_nature').change(function() { 
    //$('.pos_comp_other').val($(this).val());
    $('.project_nature_other').val('Other')  
});

</script>
{{--<script type="text/javascript" src="{{ asset('js/submit-ico.js') }}"></script>--}}
@endpush
