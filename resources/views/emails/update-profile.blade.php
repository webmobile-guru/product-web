<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{trans('emails/update-profile.Exchange_Update_Profile')}} </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
</head>
<body> 
	<div style="max-width:650px; margin:20px auto; background: #ededed; color: rgb(51, 51, 51);">
		<div style="background: #0e0d0d; text-align:center;">
			<img style="width: 70px; padding: 10px 0px;" src="https://doch.exchange/doch/img/logo.png" alt="">
		</div>
		<div style="padding:20px;">
			<h4><b>{{trans('emails/update-profile.hello')}},</b></h4>
			<div style="font-size: 14px;">
				<!--<p>{{ trans('emails/msg.body_msg') }}</p>-->
				<p>{{trans('emails/update-profile.Your_Profile_is_updated')}}.</p><br>
				<p>{{trans('emails/update-profile.thanks')}},</p>
				<p>{{ config('app.name') }}</p>
			</div>		
		</div>
		<!--<div style="background:#606568; padding:20px;">

			<p style="text-align:center; color: #d1d1d1; margin-top: 10px;">{{ trans('emails/msg.btn_text') }}</p>

		
		</div>-->
		<div style="padding:20px 0px;  background: #0b0e11; font-size: 13px; color: rgb(132, 142, 156); text-align:center;"> 
			{{trans('emails/update-profile.All_right_reserved')}}
		</div>


	</div>
</body>  
</html>
