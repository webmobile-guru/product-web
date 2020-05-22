@php $mode = session()->get('mode'); $mode = !($mode)?'live':$mode; @endphp
@extends('front.user')
@section('content')
@include('front.layout.user-header')
<section class="small_padding bg_color1">
    <div class="container">
    <div class="all_heading text-center">
        <h2>{{trans('front/account/index.Wallets')}}</h2>
      </div>
        <div class="card_shadow">
           
            <div class="table-responsive">
            
            <table class="table buy_order_table market_trade table-hover accountWalletTable">
                    <thead>
                    <tr>
                        <th>{{trans('front/account/index.Currency')}}</th>
                        <th>{{trans('front/account/index.Name')}}</th>
                        <th>{{trans('front/account/index.Active_Balance')}}</th>
                        <th>{{trans('front/account/index.On_Order')}}</th>
                        <th>{{trans('front/account/index.Total')}}</th>
                        <th>{{trans('front/account/index.Estimated_Balance')}}</th>
                        <th>{{trans('front/account/index.Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($coins as $coin)
                            <tr>
                                <td>{{ $coin->coin }}</td>
                                <td>{{ $coin->name }}</td>
                                <td>{{ number_format($user->getBalance($coin->coin),8) }}</td>
                                <td>{{ number_format(abs($user->balanceOnOrder($coin->coin)),8) }}</td>
                                <td>{{ number_format($user->totalBalance($coin->coin),8) }}</td>
                                <td>${{ number_format($user->totalBalanceInUsd($coin->coin),2) }}</td>
                                <td>
                                    

                                    @if($mode == 'live')
                                        <button name="deposit"
                                                class="inner_btn Deposit_btn sell_btn "
                                                data-url="{{ route('account.coin.deposit', $coin->coin) }}"
                                                type="button"
                                                id="depositButton"> 
                                            {{trans('front/account/index.Deposit')}}
                                        </button>
                                        <button name="withdraw"
                                                class="inner_btn Withdraw_btn buy_btn "
                                                data-url="{{ route('account.coin.withdraw', $coin->coin) }}"
                                                data-fees = {{ $coin->withdraw_fees }}
                                                        type="button" id="withdrawButton">{{trans('front/account/index.Withdraw')}}
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!--deposite_modal-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
        
            <div class="modal_inner">
            <div id="modalBody" class="modal_height bg_white"></div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        
    </div>
</div>
<!--deposite_modal-->
@endsection
@push('js')
<script>
    $(document).ready(function(){
        $('button[name=deposit]').click(function(){
            var element = $(this); 
            $.ajax({
                type:'GET',
                url: element.data('url'),
                dataType:'html',
                beforeSend:function(){
                    element.empty().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
                },
                success: function (result){
                    $('div[id=modalBody]').empty().prepend(result);
                    $('div[id=myModal]').modal({backdrop:false});
                    element.empty().html('Deposit');
                },
                error: function (result) {
                    console.log(result);
                }
            });
        });

        $('button[name=withdraw]').click(function(){
            var element = $(this);
            $.ajax({
                type:'GET',
                url: element.data('url'),
                dataType:'html',
                beforeSend:function(){
                    element.empty().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
                },
                success: function (result){
                    $('div[id=modalBody]').empty().prepend(result);
                    $('div[id=myModal]').modal({backdrop:false});
                    element.empty().html('Withdraw');
                },
                error: function (result) {
                    console.log(result);
                }
            });
        });
    });
	
	$('#myModal').on('hidden.bs.modal', function () {
	 location.reload();
	})
</script>
@endpush

