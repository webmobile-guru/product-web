<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	
	public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, 
			[	
				'email' => 'required|email|exists:users,email',
				'g-recaptcha-response' => 'required|captcha'
			],[
				'g-recaptcha-response.*' => 'Please check captcha'
			]
		);
        $user = User::where('email', $request->email)->first();

        if(!$user->profile->verified_at) {
           
			Mail::to($user->email)->queue(new VerifyEmail($user));
            flash()
                ->error('Your account has not been email verified. Please check your mail to verify your account')
                ->important();
			flash()
                ->message('We have resent a verification link to your mail')
                ->important();
            return redirect()->back();
        } else {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            if ($response === Password::RESET_LINK_SENT) {
                return back()->with('status', trans($response));
            }

            return back()->withErrors(
                ['email' => trans($response)]
            );
        }
    }
}
