<h2>Deposit {{$coin}} </h2>
<form method="post" action="{{ route('user.deposit.coin.make', 'usd') }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="student_input_area">
		<div class="form-group">
			<input class="area_input" type="text" name="amount" placeholder="{{trans('front/account/usd.Amount')}}">
			<p class="help-block"></p>
		</div>
		<div class="form-group">
			<select name="payable_currency" class="area_input">
				<option value="BTC">{{trans('front/account/usd.Bitcoin')}}</option>
				<option value="BCH">{{trans('front/account/usd.Bitcoin_Cash')}}</option>
				<option value="LTC">{{trans('front/account/usd.Litecoin')}}</option>
				<option value="XMR">{{trans('front/account/usd.Monereo')}}</option>
				<option value="LTCT">{{trans('front/account/usd.Litecoin_Testnet')}}</option>
			</select>
			<p class="help-block"></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<button type="submit" id="deposit" class="save_input">{{trans('front/account/usd.Deposit')}}</button>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<a class="cancel_input"class="close" data-dismiss="modal">{{trans('front/account/usd.Cancel')}}</a>
		</div>
	</div>
</form>
{{--<p class="italic_para">Lorem Ipsum is simply dummy text of the printing and</p>--}}
<script type="text/javascript">
	$('form').submit(function(event){
		event.preventDefault();
		var form = $(this);
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
				form.closest('div[id=modalBody]').empty().prepend(result);
				$('div[id=myModal]').modal({backdrop:false});
			},
			error: function (result) {
				form.find('button[type=submit]')
						.removeAttr("disabled")
						.empty()
						.html('Deposit');

				var errors = JSON.parse(result.responseText).errors

				if('amount' in errors) {
					var formGroup = form.find('div.form-group:eq(0)');
					formGroup.addClass('has-error');
					formGroup.find('p').text(errors.amount[0]);
				} else {
					var formGroup = form.find('div.form-group:eq(0)');
					formGroup.removeClass('has-error');
					formGroup.find('p').text('');
				}

				if('payable_currency' in errors) {
					var formGroup = form.find('div.form-group:eq(1)');
					formGroup.addClass('has-error');
					formGroup.find('p').text(errors.payable_currency[0]);
				} else {
					var formGroup = form.find('div.form-group:eq(1)');
					formGroup.removeClass('has-error');
					formGroup.find('p').text('');
				}
			}
		});
	});
</script>
