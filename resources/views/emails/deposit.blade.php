<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{trans('emails/deposit.Exchange_Enquiry')}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div style="max-width:650px; margin:20px auto; background: #ededed; color: rgb(51, 51, 51);">
		<div style="background: #0e0d0d; text-align:center;">
			<img style="width: 70px; padding: 10px 0px;" src="https://doch.exchange/doch/img/logo.png" alt="">
		</div>
		<div style="padding:20px;">
			<h4><b>{{trans('emails/deposit.hello')}},</b></h4>
			<div style="font-size: 14px;">
				<p>{{trans('emails/deposit.A_deposit_of')}} @php echo $ct["amount"].' '.$ct["coin"];  @endphp {{trans('emails/deposit.has_been_received_in_wallet')}}.  </p>
				<br>
				<p>{{trans('emails/deposit.Thanks')}},</p>
				<p>{{trans('emails/deposit.Team')}}</p>
			</div>		
		</div>
		<div style="padding:20px 0px; color: rgb(132, 142, 156); font-size: 13px; background:#0b0e11; text-align:center;">
			{{trans('emails/deposit.All_right_reserved')}}
		</div>

	</div>
</body>  
</html>


