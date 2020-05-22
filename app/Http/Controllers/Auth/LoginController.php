<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/exchange';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The layout has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
	 
	
	 
	public function showLoginForm()
    {
		$string = $this->randomString();
        $builder = new CaptchaBuilder($string);
		$builder->setMaxBehindLines(0);
		$builder->setMaxFrontLines(0);
		$builder->setBackgroundColor(255,255,255);
        $builder->build(100, 42);
		
        session()->put('phrase', $string);    

        return view('auth.login', compact('builder'));
    }
	
	protected function randomString($length = 4) {
		$str = "";
		$characters = array_merge(range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
	
    protected function authenticated(Request $request, $user)
    { 
        if(!$user->profile->verified_at) {
            auth()->logout();
            flash()
                ->error('Your account has not been email verified. Please check your mail to verify your account')
                ->important();
            return redirect()->back();
        }
        
        if($user->profile->status=='0'){
            auth()->logout();
            flash()
                ->error('Your account has been Inactive. To Active Your account, Please contact to HOTBTC')
                ->important();
            return redirect()->back();
        }
		
		
        if($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
    }
	
	
	protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha' => 'required|passed'
        ],[
            'captcha.passed' => 'Captcha is invalid'
        ]);

        session()->forget('phrase');
    }
}
