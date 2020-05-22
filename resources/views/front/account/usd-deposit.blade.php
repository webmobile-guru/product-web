@extends('admin.template.dialog')
@section('dialogTitle') Deposit {{$coin}} @endsection
@section('dialogContent')
<div class="modal-body" style="overflow:hidden">
	<div class="col-md-12">
		<form method="post" action="{{ route('user.deposit.coin.make', 'usd') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<label>{{trans('front/account/usd.Amount')}}  </label>
			<input type="text" name="amount" placeholder="{{trans('front/account/usd-deposit.Amount')}}">
			<label>{{trans('front/account/usd.Select_Coin_to_Pay')}} </label>
			<select name="payable_currency" class="form-control">
				<option value="BTC">{{trans('front/account/usd.Bitcoin')}}</option>
				<option value="BCH">{{trans('front/account/usd.Bitcoin_Cash')}}</option>
				<option value="LTC">{{trans('front/account/usd.Litecoin')}}</option>
				<option value="XMR">{{trans('front/account/usd.Monereo')}}</option>
				<option value="LTCT">{{trans('front/account/usd.Litecoin_Testnet')}}</option>
			</select>
			<div>
			  <button type="submit" class="profile_save_btn" id="deposit">{{trans('front/account/usd.Deposit')}}</button>
			</div>
		</form>
	</div>
</div>
<div class="modal-footer">
	<button type="submit" class="btn dark btn-outline" data-dismiss="modal" style="color:#777777;">{{trans('front/account/usd.Close')}}</button>
</div>
	<script type="text/javascript">
		$('form').submit(function(event){
			event.preventDefault();
			var form = $(this); console.log(form.attr('action'));
			$.ajax({
				type:'POST',
				url: form.attr('action'),
				data:form.serialize(),
				dataType:'html',
				beforeSend:function(){
					/*form.closest('div.col-md-12')
							.empty()
							.html('<i class="fa fa-spinner" aria-hidden="true"></i>');*/
					form.find('button[type=submit]')
							.attr('disabled', 'disabled')
							.empty()
							.html('<i class="fa fa-spinner" aria-hidden="true"></i>');
				},
				success: function (result){
					$('div[id=myModal]').empty().prepend(result);
					$('div[id=myModal]').modal({backdrop:false});
				},
				error: function (result) {
					form.find('button[type=submit]')
							.removeAttr("disabled")
							.empty()
							.html('Deposit');
				}
			});
		});
	</script>
@stop

