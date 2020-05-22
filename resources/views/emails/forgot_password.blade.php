<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{trans('emails/forgot_password.Exchange_Password_reset_email')}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
</head>
<body>
	<div style="max-width:650px; margin:20px auto; background: #ededed; color: rgb(51, 51, 51);">
		<div style="background: #0e0d0d; text-align:center;">
			<img style="width: 70px; padding: 10px 0px;" src="https://doch.exchange/doch/img/logo.png" alt="">
		</div>
		@php $link = url(config('app.url').route('password.reset', $token, false)); @endphp
		<div style="padding:20px;">
			<div style="font-size: 14px;">
				<p>{{trans('emails/forgot_password.hello')}},</p>
				<p>{{trans('emails/forgot_password.receiving_this_email')}}</p>
				<p>{{trans('emails/forgot_password.If_you_didnot_request')}}</p><br>
				<p>{{trans('emails/forgot_password.Thanks')}},</p>
				<p>{{trans('emails/forgot_password.Team')}}</p>
			</div>		
		</div>		
		<div style="padding:20px;">
			<p style="text-align:center; font-size: 14px;">{{trans('emails/forgot_password.Reset_your_password')}}</p>
			<a target="_blank" href="{{$link}}" style="text-decoration:none; box-shadow: 0px 10px 20px 0px rgba(242, 12, 89, 0.3); border-radius: 5px; padding: 12px 25px !important; text-align: center; color:#fff; background: linear-gradient(to right, #ff0d58 0%, #780361 100%); margin: auto; display: block; width: 110px;">{{trans('emails/forgot_password.Reset_Password')}}</a>
		</div>
	
		<div style="padding:20px 0px;  background: #0b0e11; font-size: 13px; color: rgb(132, 142, 156); text-align:center;"> 
			{{trans('emails/forgot_password.All_right_reserved')}}
		</div>
	</div>
</body>  
</html>
