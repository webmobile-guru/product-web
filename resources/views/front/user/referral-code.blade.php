@extends('front.user')
@section('content')
<!--Banner section start-->
<div class="banner_bg">
    @guest
        @include('front.layout.guest-header')
    @else
        @include('front.layout.user-header')
    @endguest
</div>
<!--Banner section end-->
   
<div class="graph_background">
	<div class="container">
        <div class="graph_padding">
            <div class="graph_bg">
                <h2>{{trans('front/user/referral-code.Your_Referral')}} </h2>
            </div>
			<div class="myprofie_section">
                        <h2 class="referal_code">{{trans('front/user/referral-code.Referral_Code')}} <strong>{{ $user->profile->referral_code }}</strong></h2>
                        <hr style="margin:5px 0 5px 0;">
                        <p class="text-center">{{trans('front/user/referral-code.Bonus')}}</p>
				 <!--#########################-->
					<form method="post" action="#" />
                        {{ csrf_field() }}
                        <p class="joining_link">
                            <strong>{{trans('front/user/referral-code.Referral_Joining_Link')}}</strong>
                            <br/>{{trans('front/user/referral-code.Please_use_the_below_link')}}
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN Portlet PORTLET-->
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-green"></i>
                                           
                                        </div>
                                    </div>
                                    <br>
                                     <ul class="list-group">
									  <li class="list-group-item">
										 <strong> {{trans('front/user/referral-code.Joining_Link')}} :</strong> <span id="left-code" class="refferel_margin" >{{ url('register?where-joining-code=').$user->profile->referral_code }}</span>
										<a href="javascript:;" class="btn btn-sm blue-steel mt-clipboard" data-clipboard-action="copy" data-clipboard-target="#left-code"><strong>{{trans('front/user/referral-code.Copy_Address')}}</strong></a>
									  </li>
									  <li class="list-group-item">
										<div class="row">
											<div class="col-lg-10 col-sm-6">
												<input type="email" name="left" class="form-control input-sm" placeholder="{{trans('front/user/referral-code.Beneficiary_Email_Address')}}" required/>
											</div>
											<div class="col-lg-2"><button style="width: 100%;" type="button" class="profile_save save_input">{{trans('front/user/referral-code.Send_Invitation')}}</button></div>
										</div>
									  </li>
									  
									</ul> 
                                    
                                    
                                    <div class="portlet-body">
                                        <div class="mt-element-card mt-element-overlay">
                                            <div class="row">
                                                <div class="col-lg-6"></h4></div>
                                                <div class="col-lg-3"></div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- END Portlet PORTLET-->
                            </div>
                        </div>
                     </form>
        <!--#########################-->
            </div>
            
        </div>
       
    </div>
    
              
</div>
@endsection
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}"/>
@endpush
@push('js')
<script type="text/javascript"  src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/global/plugins/clipboardjs/clipboard.js') }}" ></script>
<script type="text/javascript"  src="{{ asset('assets/pages/scripts/components-clipboard.js') }}" ></script>
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
                },
                success:function(result) { 
                    if(result.status){
                        Command: toastr["success"](result.message, "Mail Sent");
                        $('button.save_input').empty().html('Send Invitation');
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

