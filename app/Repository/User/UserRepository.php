<?php

namespace App\Repository\User;

use App\User;
use App\Profile;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->user, $method], $args);
    }

    public function createOrUpdate($data = [], $id = null)
    {
        if($id) {

            $userData = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email']
            ];

            $profileData = [
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip' => $data['zip'],
                'country_id' => $data['country'],
                'phone' => $data['phone'],
                'role' => $data['role'],
                'dob'=>$data['yy']."-".$data['mm']."-".$data['dd'],
                'ide_no'=>$data['ssn'],
                'ide_verify'=>$data['passport_verify'],
                'status' => $data['status'],
                'withdraw_enable_auto' => $data['withdraw_enable_auto']
            ];

            if(isset($data['password'])) {
                $user['password'] = bcrypt($data['password']);
            }

            $user = $this->user->find($id);

            return DB::transaction(function() use ($user, $userData, $profileData){

                $user->update($userData);

                $user->profile()->update($profileData);

                return $user;
            });

        } else {
            $user = [               
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ];

            $profile['ide_verify'] = isset($data['ide_verify'])?$data['ide_verify']:'0';
            $profile['ide_no'] = isset($data['ide_no'])?$data['ide_no']:null;
            $profile['dob'] = isset($data['dob'])?$data['dob']:null;
            $profile['address'] = isset($data['address'])?$data['address']:null;
            $profile['city'] = isset($data['city'])?$data['city']:null;
            $profile['zip'] = isset($data['zip'])?$data['zip']:null;
            $profile['state'] = isset($data['state'])?$data['state']:null;
            $profile['country_id'] = isset($data['country'])?$data['country']:null;
            $profile['phone'] = isset($data['phone'])?$data['phone']:null;
            $profile['role'] = isset($data['role'])?$data['role']:'subscriber';
            $profile['status'] = isset($data['status'])?$data['status']:1;
            $profile['verification_token'] = str_random(60);
            $profile['referral_code'] = 'REF'.str_random(12);
            $profile['created_by'] = isset($data['created_by'])?$data['created_by']:'admin';
            
            if(isset($data['referral_code'])) {
				$referar = Profile::where('referral_code',$data['referral_code'])->first();
                $user['referred_by'] = isset($referar->id)?$referar->user_id:null;
			}


            return DB::transaction(function() use ($user, $profile){
                $user = $this->user->create($user);

                $user->profile()->save(new Profile($profile));

                return $user;
            });
        }
    }
}
