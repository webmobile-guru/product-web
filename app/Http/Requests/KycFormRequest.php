<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KycFormRequest extends FormRequest
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
        return [
            'first_name' => 'required|string|max:255',
            'pan_card_no' => 'required|max:10',
            'pan_card' => 'required|image|max:1000',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string',
            'state' => 'required',
            'pin' => 'required',
            'address_proof' => 'required',
            'address_proof_no' => 'required',
            'address_proof_doc_front' => 'required',
            'address_proof_doc_back' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'This is a required field',
            'pan_card_no.required' => 'This is a required field',
            'pan_card.required' => 'This is a required field',
            'date_of_birth.required' => 'This is a required field',
            'address.required' => 'This is a required field',
            'state.required' => 'This is a required field',
            'pin.required' => 'This is a required field',
            'address_proof.required' => 'This is a required field',
            'address_proof_no.required' => 'This is a required field',
            'address_proof_doc_front.required' => 'This is a required field',
            'address_proof_doc_back.required' => 'This is a required field',
        ];
    }
}
