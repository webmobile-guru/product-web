<?php

namespace App\Http\Controllers;
use App\Rules\RequireWhile;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\Setting;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function profile()
    {
        $user = auth()->user();
		$referrals = User::where('referred_by',$user->id)->latest()->get();
		$limit_till_kyc_completion = Setting::where('key','limit_till_kyc_completion')->pluck('value')->first();
        return view('front.user.profile', compact('user','referrals','limit_till_kyc_completion'));
    }
    
    public function saveProfile(Request $request)
    { 
        $user = auth()->user();  
        if($user->profile->ide_verify){ 
			flash()->error("Error! You can't change your Profile, your profile is already verified.")->important();
			return redirect()->back();
		}

        $this->validate($request, [
            'fname' => 'required|min:3',           
            'lname' => 'required|min:3',           
            'country' => 'required',        
            'address' => 'required',        
            'city' => 'required',        
            'state' => 'required',        
            'zip' => 'required',        
            'country' => 'required|exists:countries,id',      
            'mm' => 'required|numeric|between:1,12',
            'dd' => 'required|numeric|between:1,31',
            'yy' => 'required|numeric|between:'.(date('Y')-100).','.date('Y'),
            'phone' => 'required',
            'tnc' => 'accepted',
            'ssn' => 'required',
            'ide_img' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ],[
			'ide_img.*' => 'Please upload image with size less than 4 MB',
			'ssn.*' => 'Please enter valid Passport Number',
			'mm.*' => 'Invalid Month',
			'dd.*' => 'Invalid Date',
			'yy.*' => 'Invalid Year',
			'fname.required' => 'Please enter first name',
			'fname.min' => 'Please enter atleast 3 characters',
			'lname.min' => 'Please enter atleast 3 characters',
			'lname.required' => 'Please enter last name',
			'tnc.*' => 'Please Accept Terms And Conditions',
		]);

        $user->first_name = $request->input('fname');
        $user->last_name = $request->input('lname');

        $profile_data=[
            'country_id'=>$request->input('country'),
            'dob'=>$request->input('yy')."-".$request->input('mm')."-".$request->input('dd'),
            'address'=>$request->input('address'),
            'city'=>$request->input('city'),
            'state'=>$request->input('state'),
            'zip'=>$request->input('zip'),
            'phone'=>$request->input('phone'),
            'ide_no'=>$request->input('ssn'),
        ]; 
                
        $path = 'public'.DIRECTORY_SEPARATOR.$user->id;

        if($request->hasFile('ide_img')) {
            $file = $request->ide_img->store($path);
            $files = explode('/',$file);
            unset($files[0]);
           $profile_data['ide_proof_photo'] = implode('/', $files);
        }

        try {

            $user->save();
            $user->profile()->update($profile_data);

            flash()->success('Success! Details has been updated')->important();

        } catch(QueryException $exception) {
            Log::error($exception->getMessage());
            flash()->error()->important('Error! Database server failed to update your record.');
        } catch(\Exception $exception) {
            flash()->error('Error! Currently unable to process your record')->important();
            Log::error($exception->getMessage());
        }
        return redirect()->back();
    }
	
	public function uploadProfileImage(Request $request)
    {
		$user = auth()->user();        

        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
		
		$path = 'public'.DIRECTORY_SEPARATOR.$user->id;
		
		if($request->hasFile('avatar')) {
            $file = $request->avatar->store($path);
            $files = explode('/',$file);
            unset($files[0]);
			/*
			if($user->profile->avatar!=""){ 
				Storage::delete(storage_path('app').DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$user->profile->avatar);
			}
			*/
			$profile_data['avatar'] = implode('/', $files);
			
			$user->profile()->update($profile_data);
			
			flash()->success('Success! Profile Image has been updated successfully')->important();
        }
		
		return redirect()->back();
	}
    
    public function referralCode()
    {
        $user = auth()->user();
        return view('front.user.referral-code', compact('user'));
    }

    public function changePassword(Request $request)
    {
		$this->validate($request, [
            'old_password' => 'required|old_password',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'old_password.old_password' => 'Old password is not valid'
        ]);

       try { 
			$user = auth()->user();
			$password=bcrypt($request->input('password'));
			$user->password=$password;
			$user->save();
			flash()->success('Success! Password has been updated')->important();
		}catch (\Exception $exception) {
			 Log::error($exception->getMessage());
			 flash()->error('Error! Change Password failed.')->important();
		}
		return redirect()->back();
	}
}
