<h3>Deposit {{$coin}} </h3>
<div class="alert hidden"></div>
<form method="post" action="{{ route('user.withdraw.coin.make', $coin) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="student_input_area">
        <div class="form-group">
            <input class="area_input" name="amount" type="text" name="amount" placeholder="{{trans('front/account/usd.Amount')}}">
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <select name="coin" name="payable_currency" class="area_input">
                <option value="">{{trans('front/account/usd.Select_Coin_to_Pay')}}</option>
                <option value="BTC">{{trans('front/account/usd.Bitcoin')}}</option>
                <option value="BCH">{{trans('front/account/usd.Bitcoin_Cash')}}</option>
                <option value="LTC">{{trans('front/account/usd.Litecoin')}}</option>
                <option value="XMR">{{trans('front/account/usd.Monereo')}}</option>
                <option value="LTCT">{{trans('front/account/usd.Litecoin_Testnet')}}</option>
            </select>
            <p class="help-block"></p>
        </div>
        <div class="form-group">
            <input class="area_input" type="text" name="address" placeholder="{{trans('front/account/usd.Receiving_Address')}}">
            <p class="help-block"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <button type="submit" class="sidenav_btn" id="withdraw">{{trans('front/account/usd.Withdraw')}}</button>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a class="cancel_input"class="close" data-dismiss="modal">{{trans('front/account/usd.Cancel')}}</a>
        </div>
    </div>
</form>
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
                form.find('button[type=submit]')
                        .removeAttr("disabled")
                        .empty()
                        .html('Withdraw');

                var out = JSON.parse(result);

                if(out.status) {
                    $('div.alert')
                            .addClass('alert-success')
                            .removeClass('hidden')
                            .text(out.message);
                } else {
                    $('div.alert')
                            .addClass('alert-danger')
                            .removeClass('hidden')
                            .text(out.message);
                }
                $('div[id=myModal]').modal({backdrop:false});
            },
            error: function (result) {
                form.find('button[type=submit]')
                        .removeAttr("disabled")
                        .empty()
                        .html('Withdraw');

                var errors = JSON.parse(result.responseText).errors;
                console.log(errors);

                if('amount' in errors) {
                    var formGroup = form.find('div.form-group:eq(0)');
                    formGroup.addClass('has-error');debugger;
                    formGroup.find('p').text(errors.amount[0]);
                } else {
                    var formGroup = form.find('div.form-group:eq(0)');
                    formGroup.removeClass('has-error');
                   formGroup.find('p').text('');
                }

                if('coin' in errors) {
                    var formGroup = form.find('div.form-group:eq(1)');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.coin[0]);
                } else {
                    var formGroup = form.find('div.form-group:eq(1)');
                    formGroup.removeClass('has-error');
                    $('p.has-error').remove();
                }

                if('address' in errors) {
                    var formGroup = form.find('div.form-group:eq(2)');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.address[0]);
                } else {
                    var formGroup = form.find('div.form-group:eq(2)');
                    formGroup.removeClass('has-error');
                    $('p.has-error').remove();
                }
            }
        });
    });
</script>
