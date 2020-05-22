@php $status = ['Pending', 'Completed', 'Failed']; $statusc = ['text-info', 'text-success', 'text-danger']; @endphp
@php $status = (auth()->user()->profile->status_two_fa == 1) ? 'Enabled' : 'Disabled'; @endphp

@extends('front.user')
@section('content')
@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest
<section class="small_padding bg_color1">
    <div class="container">
    <div class="all_heading text-center">
        <h2>My Profile</h2>
      </div>
      <div class="card_shadow">
       
        
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#my_account" role="tab" data-toggle="tab">{{trans('front/user/profile.My_Info')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#my_referal" role="tab" data-toggle="tab">{{trans('front/user/profile.My_Referral')}}</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="my_account">
                    <div>
              
									@if($user->profile->ide_verify==1)
										@php $disable_class='disabled'; @endphp
									@else
										@php $disable_class=''; @endphp
									@endif      
                     
                        <div class="row">
                            <div class="col-md-12">
							
									<br>
								      
								<form method="post" action="{{ route('profile.image.save') }}" enctype="multipart/form-data">
								   {{ csrf_field() }}
                                <div class="myprofie_section photo">
                                    <div class="myprofie_pic_inner">
                                        @if($user->profile->avatar != '')
                                            <img class="user_icon" alt="User Pic" src="{{ route('photo.get', [$user->profile->avatar]) }}" class="img-circle img-responsive">
                                        @else
                                            <img alt="User Pic" src="{{url('img/nobody_m.original.jpg')}}" class="user_icon">
                                        @endif
                                        <span class="btn-file">
                                            <i class="fa fa-camera"></i>
                                            <input type="file" name="avatar" accept="image/*">
                                        </span>
                                    </div>
									@if($errors->has('avatar'))
										<p class="text-center text-danger">{{ $errors->first('avatar') }}</p>
									@endif
                                    <h5 class="tex-center">{{ $user->full_name }}</h5>
                                    <p class="text-center text-info">{{ $user->email }}</p>

                                    <div class="btn-width">
									 
									 <button class="buy_buy_btn">{{trans('front/user/profile.Upload')}}</button>
                                    </div>
                                </div>
									
								</form>
                            </div>

                            <div class="col-md-12">
							<form method="post" action="{{ route('profile.save') }}" enctype="multipart/form-data">
								@if(!$user->profile->ide_verify)
									<div class="alert alert-warning">
                                            {{-- {{trans('front/user/profile.Your_daily_withdrawal_limit_is')}} ${{number_format($limit_till_kyc_completion)}}. {{trans('front/user/profile.Please_complete_your_profile_to_increase_your_limit')}}. --}}
                                            {{trans('front/user/profile.Please_complete_your_profile_to_increase_your_limit')}}
									</div>
								@endif
                                @include('flash::message')
								
                                <div class="padding_position">
								
								   {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group {{$errors->has('fname')?'has-error':''}}">
                                            <label>{{trans('front/user/profile.fname')}}</label>
                                            <input class="buy_sell_i md_input" type="text"  name="fname" value="{{ old('fname')?:$user->first_name }}" {{ $disable_class }}>
                                            @if($errors->has('fname'))
                                                <span class="text-danger">{{ $errors->first('fname') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group{{$errors->has('lname')?'has-error':''}}">
                                            <label>{{trans('front/user/profile.lname')}}</label>
                                            <input class="buy_sell_i md_input" type="text" name="lname" value="{{ old('lname')?:$user->last_name }}" {{ $disable_class }}>
                                            @if($errors->has('lname'))
                                                <span class="text-danger">{{ $errors->first('lname') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group{{$errors->has('country')?' has-error':''}}">
                                            <label>{{trans('front/user/profile.Country')}}</label>
                                            @php $countries = App\Country::pluck('name','id') @endphp
                                            <select class="buy_sell_i md_input" id="country" name="country" {{ $disable_class }}>
												<option value="">select</option>
                                                @foreach($countries as $key=>$country)
                                                    <option value="{{ $key }}" {{ ($key == (old('country')?:$user->profile->country_id))?'selected':'' }}>{{ $country }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('country'))
                                                <span class="text-danger">{{ $errors->first('country') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group{{$errors->has('address')?' has-error':''}}">
                                            <label>{{trans('front/user/profile.Street')}}</label>
                                            <input class="buy_sell_i md_input" name="address" type="text"value="{{ old('address')?:$user->profile->address }}" {{ $disable_class }}>
                                            @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group{{$errors->has('city')?' has-error':''}}">
                                            <label>{{trans('front/user/profile.City')}}</label>
                                            <input class="buy_sell_i md_input" type="text" name="city" value="{{ old('city')?:$user->profile->city }}" {{ $disable_class }}>
                                            @if($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group{{$errors->has('state')?' has-error':''}}">
                                            <label>{{trans('front/user/profile.State')}}</label>
                                            <input class="buy_sell_i md_input" type="text" name="state" value="{{ old('state')?:$user->profile->state }}" {{ $disable_class }}>
                                            @if($errors->has('state'))
                                                <span class="text-danger">{{ $errors->first('state') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group{{$errors->has('zip')?' has-error':''}}">
                                            <label>{{trans('front/user/profile.postal')}}</label>
                                            <input class="buy_sell_i md_input" type="text" value="{{ old('zip')?:$user->profile->zip }}" name="zip" {{ $disable_class }}>
                                            @if($errors->has('zip'))
                                                <span class="text-danger">{{ $errors->first('zip') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group {{$errors->has('phone')?'has-error':''}}">
                                            <label>{{trans('front/user/profile.phone')}}</label>
                                            <input class="buy_sell_i md_input" type="text" value="{{ old('phone')?:$user->profile->phone }}" name="phone" {{ $disable_class }}>
                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                @php
                                    $dob_date = explode(' ', $user->profile->dob);
                                    $dob = explode('-', $dob_date[0]);
                                @endphp
                                <div class="form-group{{$errors->has('mm') || $errors->has('dd') || $errors->has('yy')?' has-error':'' }}" >
                                    <label>{{trans('front/user/profile.Date_of_Birth')}}</label>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <input class="buy_sell_i md_input" type="text" placeholder="MM" name="mm" value="{{ old('mm')?:(isset($dob[1])?$dob[1]:'')}}" {{ $disable_class }}>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <input class="buy_sell_i md_input" type="text" placeholder="DD" name="dd" value="{{ old('dd')?:(isset($dob[2])?$dob[2]:'') }}" {{ $disable_class }}>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <input class="buy_sell_i md_input" type="text" placeholder="YYYY" name="yy" value="{{ old('yy')?:(isset($dob[0])?$dob[0]:'')}}" {{ $disable_class }}>
                                        </div>
                                    </div>
                                    @if($errors->has('mm') || $errors->has('dd') || $errors->has('yy'))
                                        <span class="text-danger"> {{trans('front/user/profile.Date_of_birth_is_not_valid')}} </span>{{--
                                        <span class="text-danger"> {{ $errors->first('dd') }} </span>
                                        <span class="text-danger"> {{ $errors->first('mm') }} </span>
                                        <span class="text-danger"> {{ $errors->first('yy') }} </span>--}}
                                    @endif
                                </div>
									
									
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{$errors->has('ssn')?' has-error':''}}">
                                            <label>{{trans('front/user/profile.Passport_Number')}}</label>
                                            <input class="buy_sell_i md_input" type="text" value="{{ old('ssn')?:$user->profile->ide_no }}" name="ssn" {{ $disable_class }} >
                                            @if($errors->has('ssn'))
                                                <span class="text-danger">{{ $errors->first('ssn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 

                             <div class="photo {{$errors->has('ide_img')?'has-error':''}}">
                                <label>{{trans('front/user/profile.Image_of_Your_Passport')}}:</label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <input type="file"  name="ide_img" accept="image/*" {{ $disable_class }}>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        @if($user->profile->ide_proof_photo != '')
                                            <img class="no_pdf_img" src="{{ route('photo.get', [$user->profile->ide_proof_photo]) }}" alt="img">
                                        @else
                                            <img class="no_pdf_img" src="{{ asset('images/ide_image.png') }}" alt="img">
                                        @endif
                                    </div>
                                </div>
                                @if($errors->has('ide_img'))
                                    <span class="text-danger">{{ $errors->first('ide_img') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input id="i_agree" type="checkbox" checked class="check_box" name="tnc" {{ $disable_class }}>
                                {{--<label for="i_agree" class="check_label">{{trans('front/user/profile.terms')}} </label>--}}
                                <label for="i_agree" class="check_label"> {{trans('front/user/profile.I_agree_to_the')}} <a href="{{url('terms-and-conditions')}}" target="_blank">{{trans('front/user/profile.terms_conditions')}}</a> of doch.exchange</label>
                            </div>

                            @if($errors->has('tnc'))
                            <div class="has-error">
                                <span class="text-danger has-error">{{ $errors->first('tnc') }}</span>
                            </div>
                            @endif
                            <div class="btn-width">
									 
                            <button class="buy_buy_btn" {{ $disable_class }}>{{trans('front/user/profile.Save_profile')}}</button>
							 
                            </div>
                            
                                    </div>
									</form>
                                </div>
                            </div>
                       
                    </div>
                </div>
                
                <div role="tabpanel" class="tab-pane" id="my_referal">
                    <br>
                <div class="myprofie_section">
                        <h2 class="text-center">{{trans('front/user/referral-code.Referral_Code')}} <strong>{{ $user->profile->referral_code }}</strong></h2>
                       <p class="text-center">{{trans('front/user/referral-code.Bonus')}}</p>
				 <!--#########################-->
					<form method="post" action="#" />
                        {{ csrf_field() }}
							{{--
                        <p class="text-center">
                            <strong>Referral Joining Link</strong>
                            <br/>Please use the below link to add members to your network.
                        </p>
						--}}
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN Portlet PORTLET-->
                                <div class="portlet light portlet-fit bordered">
                                    
                                    
                                     <ul class="list-group">
									  <li class="list-group-item text-center" style="word-wrap: break-word;">
										 <strong> {{trans('front/user/profile.Joining_Link')}} :</strong> <span id="left-code" class="refferel_margin">{{ url('register?where-joining-code=').$user->profile->referral_code }}</span>
										<a href="javascript:;" class="btn btn-info btn-sm blue-steel mt-clipboard" data-clipboard-action="copy" data-clipboard-target="#left-code"><strong>{{trans('front/user/profile.Copy_Address')}}</strong></a>
									  </li>
									  <li class="list-group-item">
										<div class="row">
											<div class="col-md-8 col-sm-7">
												<input type="email" name="left" class="buy_sell_i md_input" placeholder="Beneficiary Email Address" required/>
											</div>
											<div class="col-md-4 col-sm-5"><button style="margin: 0px;" type="button" class="buy_buy_btn">{{trans('front/user/profile.Send_Invitation')}}</button></div>
										</div>
									  </li>
									  
									</ul> 
                                    
                                    
                                   
                                </div>
                              
                            </div>
                        </div>
                     </form>
					 
					 
					 <div class="row">
						<div class="col-md-12">
							<!-- BEGIN Portlet PORTLET-->
							<div class="portlet light portlet-fit bordered">
								<h2 class="text-center"> <strong>{{trans('front/user/profile.Your_Referrals')}}</strong></h2>
								
								<div class="table-responsive">          
								  <table class="table">
									<thead>
									  <tr>
										
										<th>{{trans('front/user/profile.Email')}}</th>
										<th>{{trans('front/user/profile.Registered_On')}}</th>
										<th>{{trans('front/user/profile.Status')}}</th>
									  </tr>
									</thead>
									<tbody>
									  
									  @foreach($referrals as $referral)
									  <tr>
										<td>{{$referral->email}}</td>
										<td>{{$referral->created_at}}</td>
										<td>{{($referral->profile->verified_at)?'Active':'Inactive'}}</td>
									  </tr>
									  @endforeach
									</tbody>
								  </table>
								</div>
  
							</div>
						  
						</div>
					</div>

            </div>

                </div>
                
            </div> 	
        </div>
    </div>

    </div>
</section>







@endsection
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}"/>
@endpush
@push('js')
<script type="text/javascript">
    $(document).ready(function(){
       $('input[type=file]').change(function(evt){
           var __this = $(this);
           var tgt = evt.target || window.event.srcElement,
                   files = tgt.files;

           // FileReader support
           if (FileReader && files && files.length) {
               var fr = new FileReader();
               fr.onload = function () {
                   __this.closest('div.photo').find('img').attr('src', fr.result);
               }
               fr.readAsDataURL(files[0]);
           }
       });
    });
</script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>

<script type="text/javascript">
$('.nav-tabs a:first').tab('show');
$('a[data-toggle="tab"]').on('click', function (e) {
localStorage.setItem('selectedTab', $(e.target).attr('href'));
});

var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab) {
  $("a[href='" + selectedTab + "']").tab("show");
}
</script>

<script>
    $(document).ready(function () {
        $('.mt-clipboard').click(function () {
            Command: toastr["success"]("The address is copied to your clipboard.", "Copied");

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

        $('button.save_input').click(function () {

            var element = $(this).closest('div.row').find('input'); 
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(element.val())) {
                Command: toastr["error"]("Email address is not valid", "Mail Sent");
                element.focus;
                return false;
            }

            var data = {
                email: element.val(),
               // wing: element.attr('name'),
                _token:element.closest('form').find('input[name=_token]').val()
            };  
            var route = '{!! route('referral.send') !!}';
            $.ajax({
                url:route,
                type:'post',
                data:data,
                dataType:'json',
                beforeSend:function(){
                    $('button.save_input').empty().html('<i class="fa fa-spinner fa-spin"></i>');
					$('button.save_input').attr('disabled',true);
                },
                success:function(result) { 
                    if(result.status){
                        Command: toastr["success"](result.message, "Mail Sent");
                        $('button.save_input').empty().html('Send Invitation');
						element.val("");
						$('button.save_input').attr('disabled',false);
                    } else {
                        Command: toastr["error"]("Email Sending failed", "Mail Sent");
                        $('button.save_input').empty().html('Send Invitation');
						
                    }
                },
                error: function (result) { 
                    if(result.status){
                        Command: toastr["error"](result.message, "Mail Sent");
                        $('button.save_input').empty().html('Send Invitation');
                    }
                }
            });
        })
    });
</script>
@endpush
