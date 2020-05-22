<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{trans('emails/verify.Exchange_Email_verification')}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head> 
<body>
	<div style="max-width:650px; margin:20px auto; background: #ededed; color: rgb(51, 51, 51);">
		<div style="background: #0e0d0d; text-align:center;">
			<img style="width: 70px; padding: 10px 0px;" src="https://doch.exchange/doch/img/logo.png" alt="">
		</div>
		<div style="padding:20px;">
			<h4><b>{{trans('emails/verify.hello')}},</b></h4>
			<div style="font-size: 14px;">
				<p>{{trans('emails/msg.congratulation')}}</p>
				<p>{{trans('emails/msg.thanks')}},</p>
				<p>{{trans('emails/verify.Team')}}</p> 
			</div>		
		</div>
		<div style="padding:20px;">

			<p style="text-align:center">{{trans('emails/msg.activate')}} </p>

			<a href="{{ route('email-verification.check', $user->profile->verification_token) }}" style="text-decoration:none; box-shadow: 0px 10px 20px 0px rgba(242, 12, 89, 0.3); border-radius: 5px; padding: 12px 25px !important; text-align: center; color:black; background: linear-gradient(to right, #ff0d58 0%, #780361 100%); margin: auto; display: block; width: 110px;">{{trans('emails/verify.Verify')}}</a>

		</div>
		<div style="padding:20px 0px;  background: #0b0e11; font-size: 13px; color: rgb(132, 142, 156); text-align:center;"> 
			{{trans('emails/verify.All_right_reserved')}}
		</div>
	</div>
</body>  

</html>


