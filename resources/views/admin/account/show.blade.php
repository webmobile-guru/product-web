@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/account/show.Show_User_Account')}}  @endsection
@section('dialogContent')
    <div class="modal-body">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h3 class="panel-title">{{trans('admin/account/show.Account_Balances')}}</h3>
            </div>
            <div class="panel-body">
                <!-- List group -->
                <ul class="list-group">
                    {{--<li class="list-group-item">{{trans('admin/account/show.USD')}}
                        <span class="badge badge-default"> {{ number_format($user->getBalance('USD'), 2) }} </span>
                    </li>--}}
                    {{--@foreach($accounts as $account)
                        <li class="list-group-item"> {{ $account->coin->coin }}
                            <span class="badge badge-default"> {{ number_format($user->getBalance($account->coin->coin), 8) }} </span>
                        </li>
                    @endforeach--}}
                    @foreach($coins as $coin)
                        <li class="list-group-item">{{ $coin->coin }}
                            <span class="badge badge-default"> {{ number_format($user->getBalance($coin->coin), 8) }} </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/account/show.Close')}}</button>
        {{--<button type="button" class="btn green" onclick="saveCoinPair('admin/coin', $('form[id=create-coin]'))">Save changes</button>--}}
    </div>
@stop
