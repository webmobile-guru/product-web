<?php

namespace App\Http\Controllers\Admin;

use App\Withdraw;
use Carbon\Carbon;
use App\KycDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\SystemTokenWallet;
use App\SystemTokenTransaction;

use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function withdraw(Withdraw $withdraw)
    {
        $query = $withdraw->with('user');

        $request = request();

        if($request->input('from_date') && $request->input('to_date')) {
            $query = $query->whereDate('created_at', '>=', Carbon::parse($request->from_date)->toDateTimeString())
                ->whereDate('created_at', '<=', Carbon::parse($request->to_date.' 23:59:59')->toDateTimeString());
        }

        if($request->input('user_info')){
            $query = $query->whereHas('user', function ($q) use ($request){

                $q->where('email','=', $request->user_info)
                    ->orWhere('first_name', 'like', '%'.$request->user_info.'%')
                    ->orWhere('last_name', 'like', '%'.$request->user_info.'%');
            });
        }

        if($request->input('coin')){
            $query = $query->where('coin_id', $request->coin);
        }

        if($request->input('status')) {
            $array = ['pending' => 0, 'approved' => 1, 'rejected' => 2, 'canceled' => 3];
            $query = $query->where('status', $array[$request->status]);
        }

        $withdraws = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.approval.withdraw', compact('withdraws'));
    }

    public function withdrawApprove(Request $request)
    {
        $this->validate($request, [
            //'transactionHash' => 'required',
            'code' => 'required',
        ]);

        $withdrawRequest = Withdraw::where('id', $request->code)->where('status',0)->first();

        if($withdrawRequest) {
            
            try{
                    if($withdrawRequest->coin->coin==="DOCH"){

                        $system_Balance = DB::select('call sp_get_token_balance(?)',['DOCH']);
                        if($system_Balance >= $withdrawRequest->amount){
                            $transactionAmount = ($withdrawRequest->amount - $withdrawRequest->fees);
                            $to = $withdrawRequest->address;
                            $from = SystemTokenWallet::where('token',"DOCH")->pluck('address')->first();
                            $private_key = SystemTokenWallet::where('token',"DOCH")->pluck('private-key')->first();
                            $value = $transactionAmount;

                            $postData = [
                                "value"=>(string)$value,
                                "from"=>["address"=>$from, "privateKey"=>$private_key],
                                "to"=>$to
                            ];
                            
                            $payload = json_encode($postData);
                            $url = env("DOCH_NETWORK_URL")."transferToken/";
                            $headers = array("x-auth:DochCoin",'Content-Type: application/json', 'Content-Length: ' . strlen($payload));
                
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            $response = curl_exec ($ch);
                            $err = curl_error($ch);  //if you need
                            curl_close ($ch);
                
                            $returnData = json_decode($response, true);
                            if($returnData['status']=="Success"){
                                DB::transaction(function() use ($withdrawRequest, $returnData, $from, $value) {
        
                                    $withdrawRequest->CoinTransaction()->update([
                                        'reference_no' =>  $returnData['msg'],
                                        'status' => 0,
                                    ]);
                    
                                    $withdrawRequest->transaction()->update([
                                        'code' => $returnData['msg'],
                                    ]);
                    
                                    $withdrawRequest->status = 1;
                                    $withdrawRequest->save();

                                    if(!SystemTokenTransaction::where('address',$from)->where('txn',$returnData['msg'])->exists()){

                                        SystemTokenTransaction::create([
                                            'token'=>"DOCH", 
                                            'address'=>$from, 
                                            'txn'=>$returnData['msg'], 
                                            'amount'=>$value, 
                                            'status'=>0, 
                                            'type'=>'debit'
                                        ]);
                                    }
                                });
                            }
                            $result = [
                                'status' => ($returnData['status']=="Success") ? true : false, 'message' => $returnData['msg']
                            ];
                    }else{
                        $result = [
                            'status' => false, 'message' => 'Insufficient fund!'
                        ];
                    }

                    }else{

                        $transactionAmount = ($withdrawRequest->amount - $withdrawRequest->fees);
                        $cpRequest = \Coinpayments::createWithdrawal($transactionAmount, $withdrawRequest->coin->coin, $withdrawRequest->address, $withdrawRequest->dest_tag, true); 
                        if(isset($cpRequest->ref_id)){
                            DB::transaction(function() use ($withdrawRequest, $request, $cpRequest) {
    
                                $withdrawRequest->CoinTransaction()->update([
                                    'reference_no' =>  $cpRequest->ref_id,
                                    'status' => 1,
                                ]);
                
                                $withdrawRequest->transaction()->update([
                                    'code' => $cpRequest->ref_id,
                                ]);
                
                                $withdrawRequest->status = 1;
                                $withdrawRequest->save();
                            });
                            $result = [
                                'status' => true, 'message' => 'Status of withdraw has been set to approved'
                            ];

                        }else{
    
                            $result =[
                                'status' => true, 'message' => 'Transaction failed!'
                            ];
                        }

                    }
                
            } catch (QueryException $exception) {
                //Log::error($exception);
                $result = ['status' => false, 'message' => 'Error! There is an error creating withdraw request'];
            } catch (\Exception $exception) {
                //Log::error($exception);
                $result = [
                    'status' => false,
                    'message' => $exception->getMessage()
                ];
            }
            
        }else{

            $result = [
                'status' => false, 'message' => 'Withdraw request doesn\'t belongs to our database'
            ];
        }

        return json_encode($result);
    }

    public function withdrawReject(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'reason' => 'required'
        ]);

        
        
        $withdrawRequest = Withdraw::where('id', $request->code)->where('status',0)->first();


        if($withdrawRequest) {

            $withdrawRequest->remarks = $request->reason;
            $withdrawRequest->status = 2;

            DB::transaction(function() use ($withdrawRequest) {
                $withdrawRequest->transaction()->delete();
                $withdrawRequest->CoinTransaction()->update([
                    'status' => 2,
                ]);

                $withdrawRequest->save();
            });

            return json_encode([
                'status' => true, 'message' => 'Status of withdraw has been set to rejected'
            ]);
        }

        return json_encode([
            'status' => false, 'message' => 'Unable to find withdraw request with this code'
        ]);
    }
	
	
	public function withdrawCancel(Request $request)
    {

		if(auth()->guest()){
			return json_encode([
				'status' => false, 'message' => 'Your login Session has been expired! Please login again'
			]);
        }
		
        $this->validate($request, [
            'id' => 'required',
            'address' => 'required'
        ]);

        list($address, $id) = [$request->address, $request->id];

        $withdrawRequest = Withdraw::whereHas('ctransaction', function($query) use ($address, $id){
            $query->where('coinAddress', 'like', '%'.$address.'%')->where('id', $id);
        })->where('address', $request->address)->first();

        if($withdrawRequest) {

            $withdrawRequest->remarks = 'Cancelled By User';
            $withdrawRequest->status = 3;

            DB::transaction(function() use ($withdrawRequest) {
                $withdrawRequest->transaction()->delete();
                $withdrawRequest->CoinTransaction()->update([
                    'status' => 3,
                ]);

                $withdrawRequest->save();
            });

            return json_encode([
                'status' => true, 'message' => 'Status of withdraw has been set to cancel'
            ]);
        }

        return json_encode([
            'status' => false, 'message' => 'Unable to find withdraw request with this code'
        ]);
    }

    public function kycDocument()
    {
        $query = KycDocument::query();

        $request = request();

        if($request->input('from_date') && $request->input('to_date')) {
            $query = $query->whereDate('created_at', '>=', Carbon::parse($request->from_date)->toDateTimeString())
                ->whereDate('created_at', '<=', Carbon::parse($request->to_date.' 23:59:59')->toDateTimeString());
        }

        if($request->input('user_info')){

            $query = $query->whereHas('user', function ($q) use ($request){
                $q->where('email','=', $request->user_info);                    
            });

            $query = $query->orWhere('first_name', 'like', '%'.$request->user_info.'%')
                    ->orWhere('last_name', 'like', '%'.$request->user_info.'%');

        }

        if($request->input('user_dob')){
            $query = $query->where('dob','=', $request->user_info);
        }


        if($request->input('status')) {
            $array = ['pending' => 0, 'approved' => 1, 'rejected' => 2, 'canceled' => 3];
            $query = $query->where('status', $array[$request->status]);
        }

        $documents = $query->paginate(10);

        
        return view('admin.approval.kyc-document', compact('documents'));
    }

    public function showKycDocument($document)
    {
        $document = KycDocument::where('code', $document)->firstOrFail();
        
        return view('admin.approval.show-kyc-document', compact('document'));
    }

    public function processKyc(Request $request) 
    {
        
        $this->validate($request, [
            'document' => 'required|exists:kyc_documents,code'
        ]);
        
        try {
            $approve = $request->input('approve');
            $reject = $request->input('reject');
            
            $document = KycDocument::where('code', $request->input('document'))
                            ->firstOrFail();
            
            if($approve == 'true'){            
                $document->remarks = $request->input('remarks');
                $document->status = 1;
            } elseif($reject == 'true'){
                $document->remarks =  $request->input('remarks');
                $document->status = 2;
            }

            $document->save();

            flash()->success('Success! Process of kyc verification has been marked as approved');
            
        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error($exception->getMessage());
            flash()->error('Error! Process of kyc verification has been marked as rejected');
        }
        return redirect()->back();
    }
}
