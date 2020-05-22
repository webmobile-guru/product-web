<?php

namespace App\Http\Controllers\Auth;

use App\Profile;
use App\Mail\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\User\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use App\Mail\ManualEmail;
use Artisan;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/exchange';

    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('guest');
		//Mail::to('alinaaz4328@gmail.com')->cc('rashedmahamud281@gmail.com')->queue(new ManualEmail());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'referral_code' => 'nullable|exists:profiles,referral_code',
			'terms' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
			'g-recaptcha-response' => 'required|captcha'
        ],[
			'g-recaptcha-response.*' => 'Please check captcha'
		]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $data = [            
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'created_by' => 'self',
            'referral_code' => $request->input('referral_code')
        ];

        try {
            $user = $this->repository->createOrUpdate($data);
            Artisan::call('balance:demo',['userid'=>$user->id]);
            Mail::to($user->email)->queue(new VerifyEmail($user));

        } catch(\Exception $exception) {
            Log::error($exception);
			flash()->error('Some error occoured. Please try after sometime');
			return redirect()->back();
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function getVerification($token)
    {
        if($profile = Profile::where('verification_token', $token)->first()) {
            $profile->verified_at = Carbon::now();
            $profile->save();
            flash()->success('Your mail has been successfully verified');
            return redirect()->route('login');
        }
        return redirect(route('email-verification.error'));
    }

    public function getVerificationError()
    {
        return view('errors.verification');
    }

    public function registered(Request $request, $user)
    {
        return view('front.user.thank-you', compact('user'));
    }
}
