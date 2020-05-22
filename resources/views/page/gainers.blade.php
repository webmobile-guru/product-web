@extends('front.user')
@section('content')
@guest
	@include('front.layout.guest-header')
@else
	@include('front.layout.user-header')
@endguest
<section class="sm_padding all_profile_section">
    <div class="container">
    <div class="card_shadow">
         <h4>{{trans('page/gainers.Biggest_Gainers_Losers')}} </h4>
			<hr>
            <p>{{trans('page/gainers.Where_Volume')}}</p>
        <div  class="icolist_tab">
            <ul class="nav nav-tabs tabs-left gainers_tab">
                <li class="active"><a href="#1hbtc" data-toggle="tab">BTC / 1H</a></li>
                <li><a href="#24hbtc" data-toggle="tab">BTC / 24H</a></li>
                <li><a href="#7dbtc" data-toggle="tab">BTC / 7D</a></li>
            </ul>
            <div class="tab-content" style="margin-top:0px;">
                <div class="tab-pane active" id="1h">
                    <div class="table-responsive">
                        <table class="table gainers_table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('page/gainers.Pair')}}</th>
                                    <th>{{trans('page/gainers.Coin')}}</th>
                                    <th>{{trans('page/gainers.Volume')}} (BTC) </th>
                                    <th>{{trans('page/gainers.Price')}} (BTC)</th>
                                    <th>{{trans('page/gainers.Change')}} %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pairsBtc as $pair)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{--<span><img class="gainer_icon" src="{{ asset('/hotbtc/img/top01.png') }}" alt=""></span>--}} {{ $pair->pair_name }}</td>
                                        <td>{{ $pair->pairCoin->name }}</td>
                                        <td>{{ number_format($pair->getBaseVolumeFor(1), 8) }}</td>
                                        <td>{{ number_format($pair->lastPrice(), 8) }}</td>
                                        <td>{{ $pair->hourly_change }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="24hbtc">
                    <div class="table-responsive">
                        <table class="table gainers_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('page/gainers.Pair')}}</th>
                                <th>{{trans('page/gainers.Coin')}}</th>
                                <th>{{trans('page/gainers.Volume')}} (BTC)</th>
                                <th>{{trans('page/gainers.Price')}} (BTC)</th>
                                <th>{{trans('page/gainers.Change')}} %</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pairsBtc as $pair)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{--<span><img class="gainer_icon" src="{{ asset('/hotbtc/img/top01.png') }}" alt=""></span>--}} {{ $pair->pair_name }}</td>
                                    <td>{{ $pair->pairCoin->name }}</td>
                                    <td>{{ number_format($pair->getBaseVolumeFor(1, 24), 8) }}</td>
                                    <td>{{ number_format($pair->lastPrice(), 8) }}</td>
                                    <td>{{ $pair->daily_change }}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="7dbtc">
                    <div class="table-responsive">
                        <table class="table gainers_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('page/gainers.Pair')}}</th>
                                <th>{{trans('page/gainers.Coin')}}</th>
                                <th>{{trans('page/gainers.Volume')}} (BTC)</th>
                                <th>{{trans('page/gainers.Price')}} (BTC)</th>
                                <th>{{trans('page/gainers.Change')}} %</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pairsBtc as $pair)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{--<span><img class="gainer_icon" src="{{ asset('/hotbtc/img/top01.png') }}" alt=""></span>--}} {{ $pair->pair_name }}</td>
                                    <td>{{ $pair->pairCoin->name }}</td>
                                    <td>{{ number_format($pair->getBaseVolumeFor(1, 168), 8) }}</td>
                                    <td>{{ number_format($pair->lastPrice(), 8) }}</td>
                                    <td>{{ $pair->weekly_change }}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="clearfix"></div>
        </div>
        </div>
    


    </div>
</section>

@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}">
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('table.gainers_table').DataTable({
            paging: false
        });
    });
</script>
@endpush
