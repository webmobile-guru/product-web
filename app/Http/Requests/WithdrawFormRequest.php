<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawFormRequest extends FormRequest
{
    /**
     * Determine if the layout is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()?true:false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coin' => 'required|in:Bitcoin,Zcash,Merrycoin',
            'coinId' => 'required|exists:coins,id',
            'amount' => 'required|numeric|daily_limit:'.$this->coin,
            'coinAddress' => 'required|verify_wallet_address:'.$this->coin,
        ];
    }

    public function messages()
    {
        return [
            'coinId.exists' => 'This coin doesn\'t exists in our database',
            'coinId.required' => 'Request had missing parameter coin id',
            'amount.daily_limit' => 'You have exceeded your withdraw limit for today',
            'coinAddress.verify_wallet_address' => 'Address is not valid'
        ];
    }
}
