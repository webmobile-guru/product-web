<?php

namespace App\Http\Middleware;

use Closure;

class CheckForTwoFa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if($user = $request->user()) {
            $twoFaStatus = $user->profile->status_two_fa;
			
			if($twoFaStatus){
				if((!$request->session()->has('TwoFactorEnable')) && (!$request->is('en/security/two-factor/verify'))){
					return redirect()->route('security.2fa.get');
				}
			}
			else{
				if((!$request->session()->has('EmailEnable')) && (!$request->is('en/security/email/verify'))){
					return redirect()->route('security.email.get');
				}
			}
		}

        return $next($request);
    }
}
