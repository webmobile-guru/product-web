<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		switch ($this->method()) {
			case 'GET':
			case 'DELETE':
				return [];
			case 'POST':
				return [
					'coin_name' => 'required',
					'short_name' => 'required|unique:coins,coin',
					'coin_type' => 'required|in:Crypto,Fiat',
					'withdraw_m' => 'required|in:automatic,manual',
					'base_info' => 'required|in:1,0',
					'status' => 'required|in:1,0'
				];
			case 'PUT':
			case 'PATCH':
				$id = $this->segment(3);
				return [
					'coin_name' => 'required',
					'short_name' => 'required|unique:coins,coin,'.$id.',id',
					'coin_type' => 'required|in:Crypto,Fiat',
					'withdraw_m' => 'required|in:automatic,manual',
					'base_info' => 'required|in:1,0',
					'status' => 'required|in:1,0'
				];
			default:
				break;
		}
    }
    
    public function messages()
	{
		return [
			'coin_name.required' => 'Coin name is a required field!',
			'coin_name.unique' => 'Coin name already exists',
			'short_name.required' => 'Short name is a required field!',
			'base_info.required' => 'Coin base information is a required field!',
			'status.required' => 'Coin Status is a required field!',
			'withdraw_m.required' => 'Withdraw method is required field!',
			'withdraw_m.in' => 'Withdraw method should be automatic or manual!',
			'base_info.in' => 'Coin base can be YES or No',
			'status.in' => 'Coin status can be either active or inactive!',
		];
	}
}
