
<?php

return[
	'Upload_KYC_Document' => '당신의 고객 문서를 업로드하십시오',
	'Kyc_Verification' => '고객 검증 확인',
	'We_request_our_Customers' => '다음 필수 및 필수 정보를 작성하여 고객에게 확장 된 KYC 프로세스를 완료하도록 요청합니다.',
	'Name' => '당신의 이름',
	'First_Name' => '이름',
	'Middle_Name' => '중간 이름',
	'Last_Name' => '성',
	'IDENTITY_CARD_DETAIL' => '신분증 상세 정보',
	'Identity_Card_No' => '신분증 번호',
	'Upload_Identity_Card' => '신분증 업로드',
	
	'OTHER_DETAIL' => '다른 세부 사항',
	'Date_of_Birth' => '생년월일',
	'Address' => '주소',
	'State' => '상태',
	'Pin' => '핀',
	'ADDRESS_PROOF' => '주소 증명',
	'Address_Proof' => '주소 증명',
	'Passport_No' => '여권 번호',
	'Upload_Passport_Front' => '여권 업로드 (앞면)',
	'Submit_KYC' => 'KYC 제출',
	'Upload_Passport_Back' => '여권 업로드 (뒤로)'
	
];

?>

                   


                    <h2>Upload your KYC Document</h2>
                </div>
                <div class="myprofie_section">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center">Kyc Verification</h2>
                            <h4 class="text-center">We request our Customers to complete the extended KYC Process by filling the following required and mandatory information.</h4>
                            <hr>
                            <form
                                    action="{{ route('kyc.upload.store') }}"
                                    enctype="multipart/form-data"
                                    method="post">
                                {{ csrf_field() }}
                                <div class="col-md-12">
                                <p class="text-left">YOUR NAME</p>
                                    <div class="form-group col-md-4 {{ $errors->has('first_name')?'has-error':'' }}">
                                        <label for="" class="control-label">First Name</label>
                                        <input type="text" name="first_name" class="userinput_text" value="{{ old('first_name') }}">
                                        @if($errors->has('first_name'))
                                            <p class="help-block">{{ $errors->first('first_name') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 {{ $errors->has('middle_name')?'has-error':'' }}">
                                        <label for="" class="control-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="userinput_text" value="{{ old('middle_name') }}">
                                        @if($errors->has('middle_name'))
                                            <p class="help-block">{{ $errors->first('middle_name') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 {{ $errors->has('last_name')?'has-error':'' }}">
                                        <label for="" class="control-label">Last Name</label>
                                        <input type="text" name="last_name" class="userinput_text" value="{{ old('last_name') }}">
                                        @if($errors->has('last_name'))
                                            <p class="help-block">{{ $errors->first('last_name') }}</p>
                                        @endif
                                    </div>
                                    
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <p class="text-left">IDENTITY CARD DETAIL</p>
                                    <div class="form-group col-md-6 {{ $errors->has('pan_card_no')?'has-error':' ' }}">
                                        <label for="" class="control-label">Identity Card No</label>
                                        <input type="text" class="userinput_text" name="pan_card_no" value="{{ old('pan_card_no') }}">
                                        @if($errors->has('pan_card_no'))
                                            <p class="help-block">{{ $errors->first('pan_card_no') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('pan_card')?'has-error':' ' }}">
                                        <label for="" class="control-label">Upload Identity Card</label>
                                        <input type="file" class="userinput_text" accept="image/*" name="pan_card">
                                        @if($errors->has('pan_card'))
                                            <p class="help-block">{{ $errors->first('pan_card') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-left">OTHER DETAIL</p>
                                    <div class="form-group col-md-6 {{ $errors->has('date_of_birth')?'has-error':' ' }}">
                                        <label for="" class="control-label">Date of Birth</label>
                                        <input type="date" class="userinput_text" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                        @if($errors->has('date_of_birth'))
                                            <p class="help-block">{{ $errors->first('date_of_birth') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('address')?'has-error':' ' }}">
                                        <label for="" class="control-label">Address</label>
                                        <textarea cols="30" rows="5" class="userinput_text" name="address">{{ old('address') }}</textarea>
                                        @if($errors->has('address'))
                                            <p class="help-block">{{ $errors->first('address') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('state')?'has-error':' ' }}">
                                        <label for="" class="control-label">State</label>
                                        <select name="state" class="userinput_text">
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                            <option value="Daman and Diu">Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Puducherry">Puducherry</option>
                                        </select>
                                        @if($errors->has('state'))
                                            <p class="help-block">{{ $errors->first('state') }}</p>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 {{ $errors->has('pin')?'has-error':' ' }}">
                                        <div class="form-group">
                                            <label for="" class="control-label">Pin Code</label>
                                            <input type="text" class="userinput_text" name="pin" value="{{ old('pin') }}">
                                            @if($errors->has('pin'))
                                                <p class="help-block">{{ $errors->first('pin') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="text-left">ADDRESS PROOF</p>
                                    <div class="form-group col-md-6 {{ $errors->has('address_proof')?'has-error':' ' }}">
                                        <label for="" class="control-label">Address Proof</label>
                                        <select name="address_proof" id="" class="userinput_text">
                                            <option value="Passport">Passport</option>
                                            <option value="License">License</option>
                                            <option value="Voters ID">Voters ID</option>
                                            <option value="Aadhaar">Aadhaar</option>
                                        </select>
                                        @if($errors->has('address_proof'))
                                            <p class="help-block">{{ $errors->first('address_proof') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('address_proof_no')?'has-error':' ' }}">
                                        <label for="address_proof_no" class="control-label">Passport No</label>
                                        <input type="text" class="userinput_text" name="address_proof_no" value="{{ old('address_proof_no') }}">
                                        @if($errors->has('address_proof_no'))
                                            <p class="help-block">{{ $errors->first('address_proof_no') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('address_proof_doc_front')?'has-error':' ' }}">
                                        <label for="address_proof_doc_front" class="control-label">Upload Passport (Front)</label>
                                        <input type="file" class="userinput_text" name="address_proof_doc_front" accept="image/*">
                                        @if($errors->has('address_proof_doc_front'))
                                            <p class="help-block">{{ $errors->first('address_proof_doc_front') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 {{ $errors->has('address_proof_doc_back')?'has-error':' ' }}">
                                        <label for="address_proof_doc_back" class="control-label">Upload Passport (Back)</label>
                                        <input type="file" class="userinput_text" name="address_proof_doc_back" accept="image/*">
                                        @if($errors->has('address_proof_doc_back'))
                                            <p class="help-block">{{ $errors->first('address_proof_doc_back') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary">Submit KYC</button>
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
@push('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name=address_proof]').change(function(){
            var selected = $(this).find("option:selected").val();
            $('label[for="address_proof_no"]').text(selected+' No');
            $('label[for="address_proof_doc_front"]').text('Upload '+selected+' (Front)');
            $('label[for="address_proof_doc_back"]').text('Upload '+selected+' (Back)');
        });
    });
</script>
@endpush
