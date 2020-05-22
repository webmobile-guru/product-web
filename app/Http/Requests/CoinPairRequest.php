<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinPairRequest extends FormRequest
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
        switch($this->method())
		{
			case 'GET':
			case 'DELETE':
				return [];
			case 'POST':
				return [
					'pair_name' => 'required|unique:coin_pairs,pair_name',
					'secondary_coin' => 'required|exists:coins,id',
					'base_coin' => 'required|different:secondary_coin|exists:coins,id',
					'status' => 'required|in:1,0',
				];
			case 'PUT':
			case 'PATCH':
				$id = $this->segment(3);
				return [
					'pair_name' => 'required|unique:coin_pairs,pair_name,'.$id.',id',
					'secondary_coin' => 'required|exists:coins,id',
					'base_coin' => 'required|different:secondary_coin|exists:coins,id',
					'status' => 'required|in:1,0',
				];
			default:
				break;
		}
    }
    
    public function messages()
	{
		return [
			'pair_name.required' => 'Pair name is a required field',
			'secondary_coin.required' => 'Secondary coin is a required field',
			'base_coin.required' => 'Base coin is a required field',
			'status.required' => 'Status is a required field',
			'secondary_coin.exists' => 'This secondary coin doesn\'t belongs to our database',
			'base_coin.exists' => 'Given base coin doesn\'t belongs to our database',
			'base_coin.different' => 'Pairing is not possible for same coin'  
		];
	}
}
