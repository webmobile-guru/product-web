@extends('front.user')
@section('content')

@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest

<section class="small_padding bg_color1">
    <div class="container">
    <div class="all_heading text-center">
        <h2>{{trans('front/order/open.My_Trades')}}</h2>
      </div>
      <div class="card_shadow">
       
       
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#Open_Orders" role="tab" data-toggle="tab">{{trans('front/order/open.Open_Orders')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Order_History" role="tab" data-toggle="tab">{{trans('front/order/history.Order_History')}}</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div  role="tabpanel" class="tab-pane active" id="Open_Orders">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('front/order/open.Date')}}</th>
                                    <th>{{trans('front/order/open.Market')}}</th>
                                    <th>{{trans('front/order/open.Type')}}</th>
                                    <th>{{trans('front/order/open.Method')}}</th>
                                    <th class="text-center">{{trans('front/order/open.Trigger_Condition')}}</th>
                                    <th>{{trans('front/order/open.Price')}}</th>
                                    <th>{{trans('front/order/open.Volume')}}</th>
                                    <th{{-- colspan="2"--}}>{{trans('front/order/open.Amount')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trades as $trade)
                                    <tr>
                                        <td>{{ $trade->created_at }}</td>
                                        <td>{{ $trade->coinPair->pair_name }}</td>
                                        <td class="{{ ($trade->type == 'buy')?'text-info':'text-danger' }}">{{ ucfirst($trade->type) }}</td>
                                        <td>{{ $trade->method }}</td>
                                        <td class="text-center">{{ $trade->trigger?:'-' }}</td>
                                        <td>{{ number_format($trade->price, 8) }}</td>
                                        <td>{{ number_format($trade->volume, 8) }}</td>
                                        <td>{{ number_format($trade->total, 8) }}</td>
                                        {{--<td><button class="btn btn-sm text-danger orderCancel" data-pair="{{$trade->coinPair->pair_name}}" data-url="{{route('order.cancel')}}" data-id="{{$trade->id}}" title="Cancel"><i class="fa fa-times"></i></button></td>--}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">{{ $trades->links() }}</div>
                </div>
                <div  role="tabpanel" class="tab-pane" id="Order_History">
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{trans('front/order/history.Date')}}</th>
                                <th>{{trans('front/order/history.Market')}}</th>
                                <th>{{trans('front/order/history.Type')}}</th>
                                <th>{{trans('front/order/history.Price')}}</th>
                                <th>{{trans('front/order/history.Volume')}}</th>
                                <th>{{trans('front/order/history.Amount')}}</th>
                                <th>{{trans('front/order/history.Commission')}}</th>
                                <th>{{trans('front/order/history.Net_Amount')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pastTrades as $trade)
                                <tr>
                                    <td>{{ $trade->created_at }}</td>
                                    <td>{{ $trade->coinPair->pair_name }}</td>
                                    <td class="{{ ($trade->type == 'buy')?'text-info':'text-danger' }}">{{ ucfirst($trade->type) }}</td>
                                    <td>{{ number_format($trade->price, 8) }}</td>
                                    <td>{{ number_format($trade->volume, 8) }}</td>
                                    <td>{{ number_format($trade->total, 8) }}</td>
                                    <td>{{ number_format($trade->fees, 8) }}</td>
                                    <td>{{ number_format($trade->net_amount, 8) }}</td>
                                </tr>
                             @empty
									<tr>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                    </tr>
                               @endforelse
                        </tbody>
                    </table>
                    </div>
                    <div class="text-right">{{ $pastTrades->links() }}</div>
                </div>
            </div> 	
        
    </div>

    </div>
</section>

@php $status = ['Pending', 'Completed', 'Failed']; $statusc = ['text-info', 'text-success', 'text-danger']; @endphp
 

@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).on("click",".orderCancel",function() {
        var btnCancel = $(this);
		var trade_id =  $(this).attr('data-id'); 
		var url = $(this).attr('data-url');
		$.ajax({
            url:url,
            type:'POST',
            data:{'trade_id':trade_id},
            dataType:'json',
            beforeSend: function () {
                btnCancel.html('<span class="fa fa-spinner fa-spin"></span>');
            },
            success:function(result) {
                if(result.status) {
                    btnCancel.closest('tr').remove();
                }
            },
            error:function(result) {
                alert(result.message);
            },
		});
	});
</script>
@endpush
