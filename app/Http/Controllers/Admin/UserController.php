<?php

namespace App\Http\Controllers\Admin;

use App\Mail\UpdateProfileEmail;
use App\Repository\User\UserRepository;
use App\User;
use App\Mail\VerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
      $this->repository = $repository;
    }

    public function index()
    {
        $request = request();

        $query = $this->repository->exceptMe()->latest();

        if(strcasecmp($request->get('search'), 'true')==0)
        {
            if($request->has('first_name')) {
				if($request->first_name!=''){
					$query->where('first_name', 'like', "%".$request->first_name."%");
				}             
            }

            if($request->has('last_name')) {
				if($request->last_name!=''){
					$query->where('last_name', 'like', "%".$request->last_name."%");
				}                   
            }

            if($request->has('email')) {
				if($request->email!=''){
					  $query->where('email', 'like', "%".$request->email."%");
				  }
            }
            
            if($request->input('ide_verify')) {
				$search_ide_verify=$request->input('ide_verify'); 
				if($search_ide_verify==1){
					$query->whereHas('profile', function($q) use ($request) {
						$q->where('profiles.ide_verify', '1');
					});
					
				}else if($search_ide_verify==2){	
					$query->whereHas('profile', function($q) use ($request) {				
						  $q->where('profiles.ide_verify', '0')
						  ->where('profiles.ide_proof_photo', '!=',NULL);
					});
						
				}else if($search_ide_verify==3){	
					$query->whereHas('profile', function($q) use ($request) {					
						  $q->where('profiles.ide_verify', '0')
						  ->where('profiles.ide_proof_photo',NULL);
					});						
				}
            }
            if($request->input('role') and $request->input('status')) {
              $query->whereHas('profile', function($q) use ($request) {
                  $q->where('profiles.role', '=', $request->role)
                      ->where('profiles.status', '=', ['active' => 1, 'inactive' => 0][$request->status]);
              });
            }

            if(!$request->input('role') and $request->input('status')) {
              $query->whereHas('profile', function($q) use ($request) {
                  $q->where('profiles.status', '=', ['active' => 1, 'inactive' => 0][$request->status]);
              });
            }
            if($request->input('role') and !$request->input('status')) {
              $query->whereHas('profile', function($q) use ($request) {
                  $q->where('profiles.role', '=', $request->role);
              });
            }
        }

        $users = $query->paginate(10)->appends($request->query());

        return view('admin.user.index',compact('users'));
    }

    public function login($user,Request $request)
    {
      auth()->logout();
	  
	  $user_data = User::findOrFail($user);
	  if($user_data->profile->status_two_fa) {
		$request->session()->put('TwoFactorEnable', 'Y');
	  }
	
	  $request->session()->put('adminLogin', true);
      
      auth()->loginUsingId($user);
      return redirect()->to('exchange');
    }

    public function create()
    {
      return view('admin.user.create');
    }

    public function store(UserFormRequest $request)
    {
        try { 
          $user = $this->repository->createOrUpdate($request->all());
          Mail::to($user->email)->queue(new VerifyEmail($user));
          return json_encode(['status' => true, 'message' => 'Success! User created']);
        } catch (\Exception $exception) {
          Log::error('Error from user controller '.$exception->getMessage());
          return json_encode(['status' => false, 'message' => 'Error! User creation failed']);
        }
    }

    public function edit($user)
    {
        $user = $this->repository->findOrFail($user); 
        return view('admin.user.edit',compact('user'));
    }
    
    public function useredit($user){
		$user = $this->repository->findOrFail($user); 
		return view('admin.user.useredit',compact('user'));
	}

    public function update(UserFormRequest $request, $user)
    { 
        try { 
			$path = 'public'.DIRECTORY_SEPARATOR.$user;

			if($request->hasFile('ide_img')) {
				$file = $request->ide_img->store($path);
				$files = explode('/',$file);
				unset($files[0]);
			   $profile_data['ide_proof_photo'] = implode('/', $files);
			   
			   $user_data = User::findOrFail($user);
			   
			   $user_data->profile()->update($profile_data);
			}
			
			

            $user = $this->repository->createOrUpdate($request->all(), $user);
            Mail::to($user->email)->queue(new UpdateProfileEmail($user));
            return json_encode(['status' => true, 'message' => 'Success! User updated']);
        } catch (\Exception $exception) {
            Log::error('Error from user controller '.$exception->getMessage());
            return json_encode(['status' => false, 'message' => 'Error! User update failed']);
        }
    }


    public function show(User $user)
    {
        return view('admin.user.show', compact('user')); 
    }

    public function destroy($user)
    {
        if($this->repository->destroy($user)) {
        return json_encode(['status' => true, 'message' => 'Success! User deleted.']);
        }
        return json_encode(['status' => false, 'message' => 'Error! deleting layout.']);
    }
}
