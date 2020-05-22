<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the layout is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [                
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'country' => 'required',
                    'phone' => 'required|numeric',
                    'password' => 'required|min:6|confirmed',
                    'role' => 'required|in:admin,subscriber',
                    'status' => 'required|in:1,0'
                ];
            case 'PUT':
            case 'PATCH':
                $id = $this->segment(4);                
                return [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,'.$id,
                    'country' => 'required',
                    'phone' => 'required|numeric',
                    'password' => 'nullable|min:6|confirmed',
                    'role' => 'required|in:admin,subscriber',
                    'mm' => 'required|numeric|between:1,12',
					'dd' => 'required|numeric|between:1,31',
					'yy' => 'required|numeric|between:'.(date('Y')-100).','.date('Y'),
					'ssn' => 'required',
                    'status' => 'required|in:1,0'
                ];
            default:
                break;
        }
    }
}
