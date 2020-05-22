<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{trans('emails/contact-us.Exchange_Enquiry')}} </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div style="max-width:650px; margin:20px auto; background: #ededed; color: rgb(51, 51, 51);">
		<div style="background: #0e0d0d; text-align:center;">
			<img style="width: 70px; padding: 10px 0px;" src="https://doch.exchange/doch/img/logo.png" alt="">
		</div>
    <div style="padding:20px;">
        <h4><b>{{trans('emails/contact-us.hello')}}</b></h4>
        <div style="font-size: 14px;">
            <p>{{trans('emails/contact-us.Request_for_enquiry')}}</p>
            <h3>{{trans('emails/contact-us.Enquiry_Details')}}</h3>
            <p>{{trans('emails/contact-us.Name')}}: {{ $data[0] }}</p>
            <p>{{trans('emails/contact-us.Email')}}: {{ $data[1] }}</p>
            <p>{{trans('emails/contact-us.Enquiry')}}: {{ $data[2] }}</p>
            <br>
            <p>{{trans('emails/contact-us.Thanks')}},</p>
            <p>{{trans('emails/contact-us.Team')}}</p>
        </div>
    </div>
    <div style="padding:20px 0px; color: rgb(132, 142, 156); font-size: 13px; background:#0b0e11; text-align:center;">
        {{trans('emails/contact-us.All_right_reserved')}}
    </div>

</div>
</body> 
</html>
