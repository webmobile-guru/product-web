<div class="modal-header">
    <h4 class="modal-title announcement_heading">Withdraw {{$coin}}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
 </div>


 <div class="modal-body">
<div class="alert hidden info"></div>
<form id="withDrawForm" method="post" action="{{ route('user.withdraw.coin.make', $coin) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="student_input_area">
       
        
            <h6 class="text-info">{{trans('front/account/withdraw.Available_Balance')}}: <span id="availableAmount">{{number_format($balance,8)}}</span></h6>
        
		<h6 class="text-danger">{{trans('front/account/withdraw.Fees')}}: <span id="fees">{{ $fees }}%</span></h6>
		
		
        
        <div class="form-group">
            <label>{{trans('front/account/withdraw.Amount')}}: </label>
            <input class="buy_sell_i md_input" type="text" name="amount" onkeypress="return isNumberKey(event)" placeholder="{{trans('front/account/withdraw.Enter_Amount')}}">
            <p class="help-block"></p>
            
        </div>
        <p class="text-success">{{trans('front/account/withdraw.Net_Amount')}}: <span id="netAmount">0.00000000</span></p>
        <div class="form-group">
            <label>{{trans('front/account/withdraw.Receiving_Address')}}: </label>
            <input  class="buy_sell_i md_input" type="text" name="address" placeholder="{{trans('front/account/withdraw.Enter_Receiving_Address')}}">
            <p class="help-block"></p>
        </div>
        @if(in_array($coin, ['XRP','EOS']))
            <div class="form-group">
                <label>{{trans('front/account/withdraw.Destination_Tag')}}: </label>
                <input  class="buy_sell_i md_input" type="text" name="dest_tag" placeholder="{{trans('front/account/withdraw.Enter_Destination_Tag')}}">
                <p class="help-block"></p>
            </div>
        @endif
    </div>
    <div class="form-group">
        <button type="submit" class="buy_sell_btn" id="withdraw">{{trans('front/account/withdraw.Withdraw')}}</button>
    </div>
</div>
    
</form>
<script type="text/javascript">

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $('input[name=amount]').keyup(function(){

        var fees = parseFloat($('span#fees').html());
        fees = (fees > 0) ? fees : 0;
        var value = parseFloat($(this).val());
        value = (value > 0)?value:0 ;
        fees = (value*(fees/100));
        $('span#netAmount').text((value - fees).toFixed(8));
    });

    $('form').submit(function(event){
        event.preventDefault();
        var form = $(this);
        $.ajax({
            type:'POST',
            url: form.attr('action'),
            data:form.serialize(),
            dataType:'html',
            beforeSend:function(){
                form.find('button[type=submit]')
                        .attr('disabled', 'disabled')
                        .empty()
                        .html('<i class="fa fa-spinner" aria-hidden="true"></i>');
            },
            success: function (result){
                var out = JSON.parse(result);

                if(out.status) {
                    $('div.alert.info')
                            .addClass('alert-success')
                            .removeClass('alert-danger')
                            .removeClass('hidden')
                            .text(out.message);
					$('#withDrawForm').hide();
                } else {
                    $('div.alert.info')
                            .addClass('alert-danger')
                            .removeClass('alert-success')
                            .removeClass('hidden')
                            .text(out.message);
                }

                form.find('button[type=submit]')
                        .removeAttr("disabled")
                        .empty()
                        .html('Withdraw');

                $('div[id=myModal]').modal({backdrop:false});
            },
            error: function (result) {
                form.find('button[type=submit]')
                        .removeAttr("disabled")
                        .empty()
                        .html('Withdraw');

                var errors = JSON.parse(result.responseText).errors;

                if('amount' in errors) {
                    var formGroup = form.find('div.form-group:eq(0)');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.amount[0]);
                } else {
                    var formGroup = form.find('div.form-group:eq(0)');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }

                if('address' in errors) {
                    var formGroup = form.find('div.form-group:eq(1)');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.address[0]);
                } else {
                    var formGroup = form.find('div.form-group:eq(1)');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
				
				if('dest_tag' in errors) {
                    var formGroup = form.find('div.form-group:eq(2)');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.dest_tag[0]);
                } else {
                    var formGroup = form.find('div.form-group:eq(2)');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
            }
        });
    });
</script>
<style>
    .area_input{ margin: 0px !important;}
</style>
