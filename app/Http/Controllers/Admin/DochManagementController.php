<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\DepositAddress;
use App\Setting;
use App\SystemTokenWallet;
use App\TokenTransferLog;
use App\Http\Controllers\Controller;
use DB;

class DochManagementController extends Controller
{

    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function listsOfTokenAddress(){

        $dochAddressList = DepositAddress::whereHas('Coin',function($q){ $q->where('coin','DOCH'); })->paginate(10);
        foreach($dochAddressList as $key=>$list){
            $bal = $this->tokenBalance($list->address);
            $dochAddressList[$key]['eth'] = $bal['eth'];
            $dochAddressList[$key]['token'] = $bal['token'];
            $dochAddressList[$key]['estimated_gas'] = $bal['estimated_gas'];
        }
        $systemTokenAddress = SystemTokenWallet::where('token','DOCH')->pluck('address')->first();
        $getBalance = ($systemTokenAddress !== null) ? $this->tokenBalance($systemTokenAddress) : null;
        return view('admin.DochManagement.index',compact('dochAddressList','getBalance'));
    }

    private function tokenBalance($address){

        $url = env("DOCH_NETWORK_URL")."BalanceOfToken/".$address;
        $headers = array("x-auth:DochCoin");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $err = curl_error($ch);  //if you need
        curl_close ($ch);

        $balance = json_decode($response, true);
        return $balance;
    }


    private function dochSystemNewAddress(){

        $url = env("DOCH_NETWORK_URL")."new-address/";
        $headers = array("x-auth:DochCoin");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $err = curl_error($ch);  //if you need
        curl_close ($ch);

        $address = json_decode($response, true);
        return $address;
    }

    public function createNewAddress($token){

        $query = SystemTokenWallet::where('token',$token);
        if(!$query->exists()){
                $data = $this->dochSystemNewAddress();
                SystemTokenWallet::create(["token"=>$token, "address"=>$data['address'], "private-key"=>$data['privateKey']]);
                return redirect()->back();
        }
        
        return redirect()->back();
       
    }

    public function transferToken(Request $res,$token){

        $query = SystemTokenWallet::where('token',$token);
            if(!$query->exists()){
                return response()->json(["status"=>"Error", "msg"=>"System Receiver Address Not Generated"]);
            }

        if($res->mode =="internal"){
            $to = SystemTokenWallet::where('token',$token)->pluck('address')->first();
            $from = $res->to;
            $private_key = DepositAddress::where('address',$res->to)->pluck('private_key')->first();
            $value = $res->value;
        }

        if($res->mode =="userWithdrawal"){
            $to = $res->to;
            $from = SystemTokenWallet::where('token',$token)->pluck('address')->first();
            $private_key = SystemTokenWallet::where('token',$token)->pluck('private-key')->first();
            $value = $res->value;
        }

        $mode = array("internal", "userWithdrawal");
        if (in_array($res->mode, $mode)){

            $postData = [
                "value"=>$value,
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
            if($res->mode =="internal"){
                if($returnData['status']=="Success"){
                    TokenTransferLog::create([
                        'token'=>'DOCH', 'address'=>$to, 'from_address'=>$from, 'txn'=>$returnData['msg'], 'status'=>'pending', 'initiated_by'=>1
                    ]);
                }
            }
            return response()->json($returnData);
        }

    }

}