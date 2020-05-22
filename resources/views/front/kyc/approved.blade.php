@extends('front.user')
@section('content')
        <!--Banner section start-->
<div class="banner_bg">
    @include('front.layout.user-header')
</div>
<!--Banner section end-->
<div class="graph_section inner_section graph_background">
    <div class="container">
        <div class="row graph_padding">
            <div class="col-md-12 col-sm-12">
                <div class="graph_bg">
                    <h2>{{trans('front/kyc/approved.Upload_KYC_Document')}}</h2>
                </div>
                <div class="myprofie_section">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center">{{trans('front/kyc/approved.Kyc_Verification')}}</h2>
                            <h4 class="text-center">{{trans('front/kyc/approved.Kyc_Verification_completed')}}</h4>
                            <hr>
                            <form>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Name')}}</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->name }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Kyc_Status')}}</label>
                                        <span class="kycstatus_text info">{{trans('front/kyc/approved.Approved')}}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <p class="text-left">{{trans('front/kyc/approved.PANCARD_DETAIL')}}</p>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Pancard_No')}}</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->pan_card_no }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Pancard')}}</label>
                                        <span class="kycstatus_text warning">{{ str_slug($kyc->name.' pan card').'.jpg' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-left">{{trans('front/kyc/approved.OTHER_DETAIL')}}</p>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Date_of_Birth')}}</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->dob }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Address')}}</label>
                                        <textarea name="ds" cols="30" rows="5" class="userinput_text" name="address" disabled>{{ $kyc->address }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.State')}}</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->state }}" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="control-label">{{trans('front/kyc/approved.Pin')}}</label>
                                            <input type="text" class="userinput_text" name="pin" value="{{ $kyc->pin }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-left">{{trans('front/kyc/approved.ADDRESS_PROOF')}}</p>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">{{trans('front/kyc/approved.Address_Proof')}}</label>
                                        <input type="text" class="userinput_text" name="pin" value="{{ $kyc->address_proof }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address_proof_no" class="control-label">{{ $kyc->address_proof }} {{trans('front/kyc/approved.No')}}</label>
                                        <input type="text" class="userinput_text" name="address_proof_no" value="{{$kyc->address_proof_no }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address_proof_doc_front" class="control-label">{{ $kyc->address_proof }} ({{trans('front/kyc/approved.Front')}})</label>
                                        <span class="kycstatus_text warning">{{ str_slug($kyc->name.' '.$kyc->address_proof.' front').'.jpg' }}</span>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address_proof_doc_back" class="control-label">{{ $kyc->address_proof }} ({{trans('front/kyc/approved.Back')}})</label>
                                        <span class="kycstatus_text warning">{{ str_slug($kyc->name.' '.$kyc->address_proof.' back').'.jpg' }}</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
