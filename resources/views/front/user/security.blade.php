@php $status = (auth()->user()->profile->status_two_fa == 1) ? 'Enabled' : 'Disabled'; @endphp
@extends('front.user')
@section('content')
<!--Banner section start-->

		@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest

<section class="small_padding bg_color1">
	<div class="container">
		<div class="all_heading text-center">
        	<h2>{{trans('front/user/security.Security_Settings')}}</h2>
      	</div>
		<div class="card_shadow">
		

		<div class="row">
			<div class="col-md-12">
				@include('flash::message')
				<div class="with-nav-tabs">
					<div class="tab_heading">
						<ul class="nav nav-tabs">
							
							<li class="nav-item">
								<a class="nav-link active" href="#tab1primary" role="tab" data-toggle="tab">{{trans('front/user/security.Google_Authenticator')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#tab2primary" role="tab" data-toggle="tab">{{trans('front/user/security.Change_Password')}}</a>
							</li>
						</ul>
					</div>
					<div class="myprofie_section">
						<div class="tab-content">
							<br>
							<div role="tabpanel" class="tab-pane active" id="tab1primary">
								<p>{{trans('front/user/security.Two_Factor_Authentication')}} <strong><span class="{{ ['Disabled' => 'text-danger','Enabled'=> 'text-success'][$status]  }}">
											{{$status}}
										</span></strong></p>
										
								@if($status == 'Disabled')
								<p>{{trans('front/user/security.For_extra_account_security_enable')}} </p>
								
								@else
									<p>{{trans('front/user/security.For_extra_account_security_disable')}}  </p>
									
								@endif
								<p>
								<strong>{{trans('front/user/security.Google_Authenticator')}}</strong></p>
								
								
								<hr>
								<div class="row">
									<div class="col-md-3 col-sm-4">
										@php $twofa = $google2fa;
										$user = auth()->user();
										$google2fa_url = $twofa->getQRCodeGoogleUrl(
										request()->getHost(),
										$user->email,
										$user->profile->secret_two_fa
										);
										@endphp
										@if($status == 'Disabled')
											<p>{{trans('front/user/security.16digit_key')}} : <strong><span class="text-danger">{{$user->profile->secret_two_fa}}</span></strong></p>
											<img src="{{ $google2fa_url }}" alt="qr-code"><br />
										@endif
									</div>
									<div class="col-md-9 col-sm-9">
										<form action="{{ route('security.fapost') }}" method="post">
											{{ csrf_field() }}
											<div class="form-group{{ $errors->has('twofa_secret')?' has-error':' has-feedback' }}">
												<label>{{trans('front/user/security.2fa_secret')}}</label>
												<input class="buy_sell_i md_input" placeholder="{{trans('front/user/security.6Digit_Code')}}" name="twofa_secret" type="text">
												@if($errors->has('twofa_secret'))
													<p class="help-text text-danger">{{ $errors->first('twofa_secret') }}</p>
												@endif
											</div>
											@if($status == 'Disabled')
												<div class="checkbox">
													<label><input name="2fa_confirm" type="checkbox">{{trans('front/user/security.backup')}}</label>
													@if($errors->has('2fa_confirm'))
														<p class="help-text text-danger">{{ $errors->first('2fa_confirm') }}</p>
													@endif
												</div>
												{{trans('front/user/security.Before_turning')}}
											@endif
											<div class="chang_pass_section">
												<br>
											<div class="form-group">
												<button class="buy_buy_btn" type="submit">
													@if(auth()->user()->profile->status_two_fa == 0)
														{{trans('front/user/security.Enable_2FA')}}
													@else
														{{trans('front/user/security.Disable_2FA')}}
													@endif
												</button>
											</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tab2primary">
								<br>
								<div class="chang_pass_section">
									<form method="post" action="{{ route('profile.change-password') }}" enctype="multipart/form-data">
										{{ csrf_field() }}
										<div class="form-group{{$errors->has('old_password')?' has-error':' has-feedback'}}">
											<label>{{trans('front/user/security.Current_Password')}}</label>
											<input class="buy_sell_i md_input" placeholder="{{trans('front/user/security.Current_Password')}}"  name="old_password" type="password">
											@if($errors->has('old_password'))
												<p class="help-text text-danger">{{ $errors->first('old_password') }}</p>
											@endif
										</div>
										<div class="form-group{{ $errors->has('password')?' has-error':' has-feedback' }}">
											<label>{{trans('front/user/security.Password')}}</label>
											<input class="buy_sell_i md_input" placeholder="{{trans('front/user/security.New_Password')}}"  type="password" name="password">
											@if($errors->has('password'))
												<p class="help-text text-danger">{{ $errors->first('password') }}</p>
											@endif
										</div>
										<div class="form-group">
											<label>{{trans('front/user/security.Confirm_Password')}}</label>
											<input class="buy_sell_i md_input" placeholder="{{trans('front/user/security.Confirm_Password')}}"  type="password" name="password_confirmation">
										</div>
										<div class="form-group">
											<button class="buy_buy_btn" type="submit">
												{{ trans('front/user/security.Change_Password') }}
											</button>
										</div>

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
</section>
@endsection

@push('js')
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
@endpush




