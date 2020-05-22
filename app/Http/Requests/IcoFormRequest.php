<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IcoFormRequest extends FormRequest
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
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                $rules = [
                    'title' => 'required',
                    'short_description' => 'required',
                    'category' => 'required',
                    'start_date' => 'nullable|date',
                    'end_date' => 'nullable|date|after:start_date',
                    'ad_notes' => 'nullable|string',
                    'link.*' => 'url|nullable',
                    'link.website' => 'required',
                    'link.whitepaper' => 'required',
                    'link.telegram' => 'required',
                    'features' => 'required',
                    'presale' => 'required|in:no,yes,tbd',
                    'presale_start_date' => 'nullable|date',
                    'presale_end_date' => 'nullable|date',
                    'core' => 'required|array|min:1',
                    'core.*.full_name' => 'required_with:core',
                    'core.*.job_title' => 'required_with:core',
                    'advisory' => 'nullable|array',
                    'advisory.*.full_name' => 'required_with:advisory',
                    'advisory.*.job_title' => 'required_with:advisory',
                    'contact_person_name' => 'required',
                    'permission' => 'required',
                    'involvement' => 'required',
                    'contact_person_email' => 'required',
                    'marketing' => 'required',
                    'listing_fee' => 'required',
                    'soft_cap' => 'nullable|numeric', 
                    'hard_cap' => 'nullable|numeric',
                    'captcha' => 'required|passed',
                ];
                if(!$this->ajax()) {
                    $rules['logo'] = 'required|image|dimensions:min_width=70,min_height=70,max_height=1600,max_width=1600';
                }
                return $rules;
            case 'PUT':
            case 'PATCH':
                $rules =  [
                    'title' => 'required',
                    'short_description' => 'required',
                    'category' => 'required',
                    'start_date' => 'nullable|date',
                    'end_date' => 'nullable|date|after:start_date',
                    'ad_notes' => 'nullable|string',
                    'link.*' => 'url|nullable',
                    'link.website' => 'required',
                    'link.whitepaper' => 'required',
                    'link.telegram' => 'required',
                    'features' => 'required',
                    'presale' => 'required|in:no,yes,tbd',
                    'presale_start_date' => 'nullable|date',
                    'presale_end_date' => 'nullable|date',
                    'core' => 'required|array|min:1',
                    'core.*.full_name' => 'required_with:core',
                    'core.*.job_title' => 'required_with:core',
                    'advisory' => 'nullable|array',
                    'advisory.*.full_name' => 'required_with:advisory',
                    'advisory.*.job_title' => 'required_with:advisory',
                    'contact_person_name' => 'required',
                    'permission' => 'required',
                    'involvement' => 'required',
                    'contact_person_email' => 'required',
                    'marketing' => 'required',
                    'soft_cap' => 'nullable|numeric', 
                    'hard_cap' => 'nullable|numeric',
                ];
                if(!$this->ajax()) {
                    $rules['logo'] = 'nullable|image|dimensions:min_width=70,min_height=70,max_height=1600,max_width=1600';
                }
                return $rules;
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'link.*.required' => 'This is a required field',
            'link.*.url' => 'This field should be a valid url',
            'captcha.passed' => 'Captcha is invalid'
        ];
    }
}
