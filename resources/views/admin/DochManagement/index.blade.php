@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/coin/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Doch Token Management</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    System Wallet
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')

<div class="row">

    @if(App\SystemTokenWallet::where('token', "DOCH")->pluck('address')->first() !==null)
    @php $address= App\SystemTokenWallet::where('token', "DOCH")->pluck('address')->first() @endphp
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:void(0)">
            <div class="visual">
                <figure class="text-center">
                <img class="img-responsive" style="margin: auto" src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl={{$address}}"> 
                </figure>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" style="font-size: 25px; font-weight: bold;">{{$getBalance['token']}} DCH</span>
                </div>
                <div class="desc uppercase"> DOCH TOKEN </div>
                <div class="desc"><i style="font-size: 12px;">{{$address}}</i> <span class="copy_qrcode_doch_master" data-TextCopy="{{ $address }}" data-toggle="tooltip" title="Click and Copy"><i class="fa fa-clone"></i></span></div>
            </div>
        </a>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:void(0)">
            <div class="visual">
                <figure class="text-center">
                <img class="img-responsive" style="margin: auto" src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl={{$address}}"> 
                </figure>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" style="font-size: 25px; font-weight: bold;">{{$getBalance['eth']}} ETH</span>
                </div>
                <div class="desc uppercase"> Ethereum </div>
                <div class="desc"><i style="font-size: 12px;">{{$address}}</i> <span class="copy_qrcode_eth_master" data-TextCopy="{{ $address }}" data-toggle="tooltip" title="Click and Copy"><i class="fa fa-clone"></i></span></div>
            </div>
        </a>
    </div>
    @else
    <a href="{{route('admin.dochManagement.createWallet',['token'=>'DOCH'])}}" class="btn btn-block btn-primary">Add Wallet</a>
    @endif
</div>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-settings font-red"></i>
            <span class="caption-subject font-red sbold uppercase">Token</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Token</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">ETH Balance</th>
                        <th class="text-center">Token Balance</th>
                        {{--<th class="text-center">Estimated Fees</th>--}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dochAddressList as $dochAddress)
                        <tr> 
                            <td>{{ $dochAddress->id }}</td>
                            <td class="text-center">{{ $dochAddress->coin->name }}</td>
                            <td class="text-info"> 
                                <span>{{ $dochAddress->address }}</span> 
                                <span data-address="{{ $dochAddress->address }}" class="open-address show_qrcode" data-toggle="tooltip" title="Scan QR Code"><i class="fa fa-external-link"></i></span>
                                <span class="copy_qrcode" data-TextCopy="{{ $dochAddress->address }}" data-toggle="tooltip" title="Click and Copy"><i class="fa fa-clone"></i></span>
                            </td>
                            <td class="text-center">{{ $dochAddress->eth }} ETH</td>
                            <td class="text-center">{{ $dochAddress->token }} DOCH</td>
                            {{--<td class="text-center">{{ $dochAddress->estimated_gas }} ETH</td>--}}
                            <td class="text-center">
                                @php $status = App\TokenTransferLog::where('from_address',$dochAddress->address)->where('status','pending')->pluck('status')->first(); @endphp
                                @if($status === null || $status==='completed')
                                    <button name="doTransfer" data-loading-text="<i class='fa fa-spinner fa-spin '></i> submit Transaction" type="button" data-token="{{$dochAddress->token}}" data-address="{{ $dochAddress->address }}"   class="doTransfer btn btn-outline btn-circle btn-sm yellow">Transfer</button>
                                @else
                                   <a href="javascript:void(0);" class="btn btn-outline btn-circle btn-sm yellow" ><i class='fa fa-spinner fa-spin '></i> Confirming Transaction</a>
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
        {{ $dochAddressList->links() }}  
    </div>




    
<!-- Modal -->
<div class="modal fade" id="address-show" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Address</h4>
      </div>
      <div class="modal-body">
        <div class="qrcode_inner">
            <img id="qrcode" src="" alt="">
         </div>
         <p class="text-info text-center" id="qrcode_address"></p>
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->

</div>
@endsection

@push('js')



<script type="text/javascript">
	$('.copy_qrcode').click(function(){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr("data-TextCopy")).select();
        document.execCommand("copy");
        $temp.remove();
    });

    $('.copy_qrcode_doch_master').click(function(){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr("data-TextCopy")).select();
        document.execCommand("copy");
        $temp.remove();
    });

    $('.copy_qrcode_eth_master').click(function(){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr("data-TextCopy")).select();
        document.execCommand("copy");
        $temp.remove();
    });

    
    $(document).ready(function(){  
        $(".open-address").click(function(){
            var address =  $(this).attr('data-address');
            $('#qrcode').attr('src','https://chart.googleapis.com/chart?chs=300x300&cht=qr&amp;chl='+address);
            $('#qrcode_address').html(address);
            $("#address-show").modal('show');
        });
        $(".doTransfer").click(function(){

            var $btn = $(this);
            $btn.button('loading');
            var toAddress = $(this).attr("data-address");
            var token = $(this).attr("data-token");
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                }
                });
                $.ajax({
                    url:"{{route('admin.dochManagement.transfer',['token'=>'DOCH'])}}",
                    type:'POST',
                    data:{to:toAddress,value:token,mode:'internal'},
                    dataType:'json',
                    success:function(result){
                        alert(result.msg);
                        $btn.button('reset');
                        if(result.status==='Success'){
                            location.reload();
                        }
                        
                    }
                });
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush