<?php

namespace App\Http\Controllers;

use App\Http\Requests\KycFormRequest;
use App\KycDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KycController extends Controller
{
    public function upload()
    {
        $user = auth()->user();
        $kyc = $user->kyc()->latest()->first();

        if($kyc) {
            if ($kyc->status == 0){
                return view('front.kyc.pending', compact('kyc'));
            }
            if ($kyc->status == 1) {
                return view('front.kyc.approved', compact('kyc'));
            }
        }
        return view('front.kyc.upload');
    }

    public function submitKyc(KycFormRequest $request)
    {
        try {

            $user = Auth::user();

            $docDate = [
                'code' => uniqid(str_random(10)),
                'user_id' => $user->id,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'pan_card_no' => $request->input('pan_card_no'),
                'dob' => $request->input('date_of_birth'),
                'address' => $request->input('address'),
                'state' => $request->input('state'),
                'pin' => $request->input('pin'),
                'address_proof' => $request->input('address_proof'),
                'address_proof_no' => $request->input('address_proof_no'),
            ];

            $path = 'public'.DIRECTORY_SEPARATOR.$user->id.DIRECTORY_SEPARATOR.'kyc';

            $file = $request->pan_card->store($path);
            $files = explode('/',$file);
            unset($files[0]);
            $docDate['pan_doc'] = implode('/', $files);

            $file = $request->address_proof_doc_front->store($path);
            $files = explode('/',$file);
            unset($files[0]);
            $docDate['address_proof_doc_front'] = implode('/', $files);

            $file = $request->address_proof_doc_back->store($path);
            $files = explode('/',$file);
            unset($files[0]);
            $docDate['address_proof_doc_back'] = implode('/', $files);

            KycDocument::create($docDate);

            flash()->success('Success! Kyc document has been submitted.');

        } catch (\Exception $exception) {
            Log::error($exception);

            flash()->error('Error! There is an error submitting kyc detail.');
        }

        return redirect()->route('kyc.upload.index');
    }
}
