@php $status = ['Pending', 'Completed', 'Failed']; $statusc = ['text-info', 'text-success', 'text-danger']; @endphp
@extends('front.user')
@section('content')

@include('front.layout.user-header')

<section class="small_padding bg_color1">
	<div class="container">
	<div class="all_heading text-center">
        <h2>{{trans('front/account/history.Deposit_Withdrawal_History')}}</h2>
      </div>
		 <div class="card_shadow">
			
			
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="#Deposits_history" role="tab" data-toggle="tab">{{trans('front/account/history.Deposits')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#Withdraw_history" role="tab" data-toggle="tab">{{trans('front/account/history.Withdraw')}}</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="Deposits_history">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
							<tr>
								<th>{{trans('front/account/history.Date')}}</th>
								<th>{{trans('front/account/history.Coin')}}</th>
								<th>{{trans('front/account/history.Address_Transaction_ID')}}</th>
								<th>{{trans('front/account/history.Amount')}}</th>
								<th>{{trans('front/account/history.Status')}}</th>
							</tr>
							</thead>
							<tbody>
							@forelse($deposits as $cTransaction)
								<tr>
									<td>{{ $cTransaction->created_at }}</td>
									<td>{{ $cTransaction->coin->coin }}</td>
									<td><span>{{trans('front/account/history.Address')}}: {{ $cTransaction->coin_address }}</span><br/><span>{{trans('front/account/history.TxnID')}}:{{ $cTransaction->reference_no }}</span>
									
									</td>
									<td>
										@php
										$amount = $cTransaction->amount;
										$fees = isset($cTransaction->fees)?$cTransaction->fees:0;
										@endphp
										<span> {{ number_format($amount, 8) }}</span><br/>
											{{--<span>{{trans('front/account/history.Fees')}}: {{ number_format($fees, 8) }}</span><br/>
											<span>{{trans('front/account/history.Net_Amount')}}: {{ number_format(($amount - $fees), 8) }}</span>--}}
									</td>
									<td class="{{ $statusc[$cTransaction->status] }}">{{ $status[$cTransaction->status] }}</td>
								</tr>
							@empty
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							@endforelse
							</tbody>
						</table>
						</div>
						<div class="text-right">
							{{$deposits->links("pagination::bootstrap-4")}}
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="Withdraw_history">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
							<tr>
								<th>{{trans('front/account/history.Date')}}</th>
								<th>{{trans('front/account/history.Coin')}}</th>
								<th>{{trans('front/account/history.Address_Transaction_ID')}}</th>
								<th>{{trans('front/account/history.Amount')}}</th>
								<th>{{trans('front/account/history.Status')}}</th>
							</tr>
							</thead>
							<tbody>
								@forelse($withdraw as $transaction)
									<tr>
										<td>{{ $transaction->created_at }}</td>
										<td>{{ $transaction->coin->coin }}</td>
										

										<td>
											<span>{{trans('front/account/history.Address')}}: {{ $transaction->coin_address }}</span><br/>
											@php
												$data = explode('#', $transaction->reference_no);
											@endphp
											@isset($data[0])
												<span>{{trans('front/account/history.TxnID')}}:{{ $data[0] }}</span>
											@endisset
											@isset($data[1])
												<br>
												<span>{{trans('front/account/history.Txn_Hash')}}:{{ $data[1] }}</span>
											@endisset
											@if($transaction->status==2)
												<br/><span>{{trans('front/account/history.Reason')}}:{{ $transaction->withdraw->remarks }}</span>
											@endif
										</td>
										<td>
											@php
												$amount = $transaction->amount;
												$fees = isset($transaction->fees)?$transaction->fees:0;
											@endphp
											<span>{{trans('front/account/history.Amount')}}: {{ number_format($amount, 8) }}</span><br/>
											<span>{{trans('front/account/history.Fees')}}: {{ number_format($fees, 8) }}</span><br/>
											<span>{{trans('front/account/history.Net_Amount')}}: {{ number_format(($amount - $fees), 8) }}</span>
										</td>
										<td class="{{ $statusc[$transaction->status] }}">{{ $status[$transaction->status] }}</td>
									</tr>
								@empty
									<tr>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
									</tr>
								@endforelse
								
							</tbody>
						</table>
						</div>
						<div class="text-right">
							{{$withdraw->links("pagination::bootstrap-4")}}
						</div>
					</div>
				</div> 	
			
		</div>
	</div>
</section>


@endsection
