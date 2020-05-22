@if($cpTansaction)
	<h3>Deposit {{$cpTansaction->currency2}} </h3>
	<div class="col-md-12 text-center">
		<img src="{{ $cpTansaction->qrcode_url }}" alt="{{ $cpTansaction->address }}">
	</div>
	<div class="col-md-12">
		<p><strong>{{trans('front/account/usd-deposited.Address')}}</strong>{{ $cpTansaction->address }}</p>
		<p><strong>{{trans('front/account/usd-deposited.Transaction_ID')}}</strong>{{ $cpTansaction->txn_id }}</p>
		<p><strong>{{trans('front/account/usd-deposited.Amount')}}</strong>{{ $cpTansaction->amount }}</p>
		<p><strong>{{trans('front/account/usd-deposited.Currency')}}</strong>{{ $cpTansaction->currency2 }}</p>
	</div>
	<div class="col-md-12 text-center">
		<a class="save_input" href="{{ $cpTansaction->status_url }}" target="_blank">{{trans('front/account/usd-deposited.Check_Status')}}</a>
	</div>
@else
	Failed to deposit amount
@endif