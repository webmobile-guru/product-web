
<?php

return[
	'Upload_KYC_Document' => 'Upload your KYC Document',
	'Kyc_Verification' => 'Kyc Verification',
	'We_request_you_to_please_wait' => 'We request you to please wait for few moment while our executive go through your application and process the same.',
	'Name' => 'Name',
	'Kyc_Status' => 'Kyc Status',
	'Pending' => 'Pending',
	'PANCARD_DETAIL' => 'PAN CARD DETAIL',
	'Pancard_No' => 'Pan Card No',
	'Pancard' => 'Pancard',
	'InReview' => 'In Review',	
	'OTHER_DETAIL' => 'OTHER DETAIL',
	'Date_of_Birth' => 'Date of Birth',
	'Address' => 'Address',
	'State' => 'State',	
	'Pin' => 'Pin',
	'ADDRESS_PROOF' => 'ADDRESS PROOF',
	'Address_Proof' => 'Address Proof',
	'No' => 'No',
	'Front' => 'Front',
	'Back' => 'Back'
	
];

?>

                   

                            <h2 class="text-center">Kyc Verification</h2>
                            <h4 class="text-center">We request you to please wait for few moment while our executive go through your application and process the same.</h4>
                            <hr>
                            <form>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Name</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->name }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Kyc Status</label>
                                        <span class="kycstatus_text info">Pending</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <p class="text-left">PAN CARD DETAIL</p>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Pan Card No</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->pan_card_no }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Pan Card</label>
                                        <span class="kycstatus_text warning">In Review</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-left">OTHER DETAIL</p>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Date of Birth</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->dob }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Address</label>
                                        <textarea name="ds" cols="30" rows="5" class="userinput_text" name="address" disabled>{{ $kyc->address }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">State</label>
                                        <input type="text" class="userinput_text" value="{{ $kyc->state }}" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="control-label">Pin</label>
                                            <input type="text" class="userinput_text" name="pin" value="{{ $kyc->pin }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-left">ADDRESS PROOF</p>
                                    <div class="form-group col-md-6">
                                        <label for="" class="control-label">Address Proof</label>
                                        <input type="text" class="userinput_text" name="pin" value="{{ $kyc->address_proof }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address_proof_no" class="control-label">{{ $kyc->address_proof }} No</label>
                                        <input type="text" class="userinput_text" name="address_proof_no" value="{{$kyc->address_proof_no }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address_proof_doc_front" class="control-label">{{ $kyc->address_proof }} (Front)</label>
                                        <span class="kycstatus_text warning">In Review</span>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="address_proof_doc_back" class="control-label">{{ $kyc->address_proof }} (Back)</label>
                                        <span class="kycstatus_text warning">In Review</span>
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
