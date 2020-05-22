@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/trade/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/trade/index.Trade')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/trade/index.Trade')}}
    <small>{{trans('admin/trade/index.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/trade/index.Explore_Trade')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <div class="row">
                <div class="col-md-4 col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">{{trans('admin/trade/index.Trade_Detail')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{trans('admin/trade/index.Coin_Pair')}}</th>
                                <td>{{ $trade->coinPair->pair_name }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('admin/trade/index.Type')}}</th>
                                <td>{{ ucfirst($trade->type) }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('admin/trade/index.Volume')}}</th>
                                <td>{{ number_format($trade->volume, 8) }} {{ $trade->coinPair->pairCoin->coin }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('admin/trade/index.Price')}}</th>
                                <td>{{ number_format($trade->price, 8) }} {{ $trade->coinPair->baseCoin->coin }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('admin/trade/index.Fees')}}</th>
                                <td>{{ number_format($trade->fees, 8) }} {{ $trade->coinPair->baseCoin->coin }}</td>
                            </tr>
                            <tr>
                                <th>{{trans('admin/trade/index.Total')}}</th>
                                <td>{{ number_format($trade->total, 8) }} {{ $trade->coinPair->baseCoin->coin }}</td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-sm-12">                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">{{trans('admin/trade/index.Partial_Close')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <form action="{{ route('admin.trade.partial', [encrypt($trade->id)]) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('volume')?' has-error':'' }}">
                                            <label for="volume" class="control-label">{{trans('admin/trade/index.Volume_to_close')}}</label>
                                            <input class="form-control text-right" 
                                                type="text" 
                                                name="volume"
                                                data-volume="{{$trade->volume}}" 
                                                data-type="{{ $trade->type }}" 
                                                data-maker="{!! \App\Setting::getFees('maker_fee') !!}" 
                                                data-taker="{!! \App\Setting::getFees('taker_fee') !!}">
                                            <p class="help-block text-danger">{{ $errors->first('volume') }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="price" class="control-label">{{trans('admin/trade/index.Price')}}</label>
                                            <span class="form-control text-right" type="text" name="price">{{ number_format($trade->price, 8) }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="fees" class="control-label">{{trans('admin/trade/index.Fees')}}</label>
                                            <span class="form-control text-right" type="text" name="fees">0.00000000</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="total" class="control-label">{{trans('admin/trade/index.Total')}}</label>
                                            <span class="form-control text-right" type="text" name="total">0.00000000</span>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-warning btn-block">{{trans('admin/trade/index.Close')}}</button>                                        
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-sm-12">                    
                    <table class="table table-bordered">                    
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-success btn-block" name="close" data-url="{{ route('admin.trade.close', [encrypt($trade->id)]) }}">{{trans('admin/trade/index.Close')}}</button>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-danger btn-block" name="cancel" data-url="{{ route('admin.trade.cancel', [encrypt($trade->id)]) }}">{{trans('admin/trade/index.Cancel')}}</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>                                        
</div>
@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
    
        $('input[name=volume]').keyup(function(){
            var element = $(this);
            
            var volume = $(this).val();

            var maxVolume = element.data('volume');
            
            if(volume > maxVolume) {
                element.closest('div.form-group')
                .find('p')
                .removeClass('hidden')
                .text('Volume is higher than ' + maxVolume)
            
            } else {
                element.closest('div.form-group').find('p').addClass('hidden')
            }

            var price = $('span[name="price"]').html();

            volume = (volume == undefined) ? 0 : parseFloat(volume);
            price = (price == undefined) ? 0 : parseFloat(price);

            var type = element.data('type');
            var fee = (type == 'buy')?element.data('taker'):element.data('maker');

            fee = (fee == undefined) ? 0 : parseFloat(fee);

            netAmount = (price * volume);
            feeAmount = netAmount * (fee / 100);
        
            var total = (type == 'buy')? (netAmount + feeAmount):(netAmount - feeAmount);

            $('span[name=fees]').html(feeAmount.toFixed(8));
            $('span[name=total]').html(total.toFixed(8));
        });

        /* $('button[name=partial]').click(function(){
            var url  = $(this).data('url')
            bootbox.confirm('Are you sure you want to close the order?', function(result){
              if(result){
                  window.location.href = url;
              }
            });
        }); */

        $('button[name=close]').click(function(){
            var url  = $(this).data('url')
            bootbox.confirm('Are you sure you want to close the order?', function(result){
              if(result){
                  window.location.href = url;
              }
            });
        });

        $('button[name=cancel]').click(function(){
            var url  = $(this).data('url')
            bootbox.confirm('Are you sure you want to cancel the order?', function(result){
                if(result){
                    window.location.href = url;
                }
            });
        });
    });

</script>
@endpush

