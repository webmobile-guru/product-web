<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotification;
use App\Mail\SendOtp;
use App\UserLog;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function security_2fa()
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        if((!$user->profile->status_two_fa) && (!$user->profile->secret_two_fa)){
            $twofakey = $google2fa->generateSecretKey();

            $user->profile->secret_two_fa = $twofakey;

            $user->profile->save();
        }

        return view('front.user.security',compact('google2fa'));
    }

    public function security_2fa_post(Request $request)
    {
        $rules = [
            'twofa_secret' => 'required|digits:6',
        ];
        $user = auth()->user();

        if(!($user->profile->status_two_fa)) {
            $rules['2fa_confirm'] = 'required';
        }

        $this->validate($request, $rules, [
            'twofa_secret.required' => 'Two factor code is required',
            '2fa_confirm.required' => 'Please take a backup of key for future use',
            'twofa_secret.digits' => 'Please Enter Valid Two factor code'
        ]);

        $google2fa = new Google2FA();
        $secret = $request->input('twofa_secret');
        $valid = $google2fa->verifyKey($user->profile->secret_two_fa, $secret);

        if($valid) {
            if($user->profile->status_two_fa){
				$user->profile->secret_two_fa = $google2fa->generateSecretKey();
                $user->profile->status_two_fa = 0;
                $user->profile->save();               
            }else{
                $user->profile->status_two_fa=1;
                $user->profile->save();

                $request->session()->put('TwoFactorEnable', 'Y');
            }
            flash()->success('Success! Successfully update')->important();
        }else{

            flash()->error('Error! Secret key is invalid')->important();
        }

        return redirect()->back();

    }

    public function getTwoFaVerification()
    {
		
		if(request()->session()->has('TwoFactorEnable')) {
			return redirect()->to('/');
		}

        return view('auth.verify-twofa');
    }

    public function postTwoFaVerification(Request $request, Google2FA $google2fa)
    {
        $this->validate($request, [
            'code' => 'required|digits:6',
        ]);

        $user = auth()->user();
        $secret = $request->input('code');
        $secretStored = $user->profile->secret_two_fa;

        $valid = $google2fa->verifyKey($secretStored, $secret);
        
        $ip = request()->ip();
			
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client = $request->header('User-Agent');
		$arr= ['ip' => $ip,'user_id'=>$user->id,'client'=>$client ]; 
		UserLog::create($arr); 

        if($valid) {
            $request->session()->put('TwoFactorEnable', 'Y');
            return redirect()->intended();
        }

        flash()->error('Error! Invalid 2FA Code');

        return redirect()->route('security.2fa.get');
    }
	
	
	public function getEmailVerification()
    {
		if(request()->session()->has('EmailEnable')) {
			return redirect()->to('/');
		}
		
		$otp = $this->randomString();
		
		request()->session()->put('EmailOtp', $otp);
		Mail::to(auth()->user()->email)->queue(new SendOtp($otp));
		
		return view('auth.verify-email');
	}

    public function postEmailVerification(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|digits:6',
        ]);
		
		
        if($request->input('code')==$request->session()->get('EmailOtp')) {
            $request->session()->put('EmailEnable', 'Y');
			
			$ip = request()->ip();
			
			if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
				$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
			}
			$user = auth()->user();
			$client = $request->header('User-Agent');
			$arr= ['ip' => $ip,'user_id'=>$user->id,'client'=>$client ]; 
			UserLog::create($arr); 
			
			Mail::to(auth()->user()->email)->queue(new LoginNotification($ip));
            
            if($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended();
        }

        flash()->error('Error! Invalid Email Code. We have resent the email containing code');

        return redirect()->route('security.email.get');
    }
	
	protected function randomString($length = 6) {
		$str = "";
		$characters = array_merge(range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
}
