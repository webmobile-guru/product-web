@php 
if($coinAddress){
	if(isset($coinAddress->address)){
		$addressToShow = $coinAddress->address;
	}else{
		$addressToShow = $coinAddress;
	}
}
@endphp 
<div class="modal-header">
    <h4 class="modal-title announcement_heading">Deposit {{$coin}}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
 </div>

    <div class="modal-body">
        <!--<div class="alert alert-info text-center">
            Amount <strong>{{ number_format(0.5, 2) }}%</strong> will be deducted as deposit fee
        </div>-->
        @if($coinAddress)
        <div class="fig_width">
            <figure class="text-center">
                <img class="img-responsive" style="margin: auto" src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl={{ $addressToShow }}">
                
            </figure>
        </div>
        <figcaption class="text-info text-center">{{ $addressToShow }}</figcaption>
            @if(isset($coinAddress->dest_tag))
                <p class="text-center">{{trans('front/account/deposit.Destination_Tag')}} : {{ $coinAddress->dest_tag }}</p>
            @endif
            
        @else
            <p class="text-center"> {{trans('front/account/deposit.Deposit_is_temporarily_disabled')}}  </p>
        @endif
    </div>

