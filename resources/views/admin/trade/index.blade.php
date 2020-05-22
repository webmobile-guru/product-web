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
        @include('flash::message')
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/trade/index.Search_By')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form role="form" method="get" action="{{ route('admin.trade.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{trans('admin/trade/index.Trade_Date_Between')}}</label>
                            <div class="input-group date-picker input-daterange">
                                <input type="text" class="form-control" name="from_date" value="{{ request()->from_date }}">
                                <span class="input-group-addon">To</span>
                                <input type="text" class="form-control" name="to_date"  value="{{ request()->to_date }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/trade/index.User')}}</label>
                            <input type="text" name="user_info" value="{{ request()->user_info }}" class="form-control" placeholder="{{trans('admin/trade/index.Enter_User_Info')}}">
                        </div>

                        <div class="col-md-4">
                            <label for="">{{trans('admin/trade/index.Coin_Pair')}}</label>
                            {{--<input type="text" name="coin_pair" value="" class="form-control" placeholder="Enter Coin Pair">--}}
                            <select name="coin_pair" class="form-control">
                                @foreach(App\CoinPair::all() as $coin) 
                                    <option value="{{ $coin->id }}" @if(request()->coin_pair == $coin->id) selected @endif>{{ $coin->pair_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/trade/index.Trade_Type')}}</label>
                            <select name="trade_type" class="form-control">
                                <option value="">-- {{trans('admin/trade/index.Select_Type')}} --</option>
                                <option value="buy" @if(request()->trade_type == 'buy') selected @endif>{{trans('admin/trade/index.Buy')}}</option>
                                <option value="sell" @if(request()->trade_type == 'sell') selected @endif>{{trans('admin/trade/index.Sell')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/trade/index.Trade_Status')}}</label>
                            <select name="status" class="form-control">
                                <option value="">-- {{trans('admin/trade/index.Select_Status')}} --</option>
                                <option value="ongoing" @if(request()->status == 'ongoing') selected @endif>{{trans('admin/trade/index.Ongoing')}}</option>
                                <option value="closed" @if(request()->status == 'closed') selected @endif>{{trans('admin/trade/index.Closed')}}</option>
                                <option value="cancelled" @if(request()->status == 'cancelled') selected @endif>{{trans('admin/trade/index.Cancelled')}}</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/trade/index.Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/trade/index.User_Trade_Management')}}</span>
                </div>
                {{ $trades->links() }}           
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">{{trans('admin/trade/index.Date')}}</th>
                                <th class="text-center">{{trans('admin/trade/index.User')}}</th>
                                <th class="text-center">{{trans('admin/trade/index.Trade_Detail')}}</th>
                                <th class="text-center">{{trans('admin/trade/index.Status')}}</th>
                                <th class="text-center">{{trans('admin/trade/index.Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trades as $trade)
                                <tr> 
                                    <td>{{ $trade->id }}</td>
                                    <td class="text-center">{{ $trade->created_at->toFormattedDateString() }}</td>
                                    <td class="text-center">{{ $trade->user->email }}</td>
                                    <td>
                                        <p><strong>{{trans('admin/trade/index.Coin_Pair')}}</strong>: {{ $trade->coinPair->pair_name }}</p>
                                        <p><strong>{{trans('admin/trade/index.Type')}}</strong>: {{ ucfirst($trade->type) }}</p>
                                        <p><strong>{{trans('admin/trade/index.Amount')}}</strong>: {{ number_format($trade->volume, 8) }}</p>
                                        <p><strong>{{trans('admin/trade/index.Price')}}</strong>: {{ number_format($trade->price, 8) }}</p>
                                        <p><strong>{{trans('admin/trade/index.Extra_Amount')}}</strong>: {{ number_format($trade->fees, 8) }}</p>
                                        <p><strong>{{trans('admin/trade/index.Total')}}</strong>: {{ number_format($trade->total, 8) }}</p>
                                    </td>
                                    <td>
                                        {{ ['Ongoing', 'Closed', 'Cancelled'][$trade->status] }}
                                    </td>
                                    <td class="text-center">
                                        @if($trade->status == 0)
                                            {{--<button class="btn btn-warning" name="close" data-url="{{ route('admin.trade.close', [$trade->id]) }}">{{trans('admin/trade/index.Partial')}}</button>
                                            
                                            --}}
                                            
                                            <a class="btn btn-warning" name="explore" href="{{ route('admin.trade.explore', [encrypt($trade->id)]) }}"><i class="fa fa-plus"></i> {{trans('admin/trade/index.Explore')}}</button>
                                        @else
                                           {{trans('admin/trade/index.Not_Available')}}                                     
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr> 
                                    <td colspan="9" class="text-center text-danger">{{trans('admin/trade/index.No_Account')}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    p{margin: 5px;}
</style>
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.date-picker').datepicker({
            orientation: "bottom",
            autoclose: true
        });

        $('button[name=partial]').click(function(){
            var url  = $(this).data('url')
            bootbox.confirm('Are you sure you want to close the order?', function(result){
              if(result){
                  window.location.href = url;
              }
            });
        });

        /*$('button[name=close]').click(function(){
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
        });*/
    });

</script>
@endpush

