<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterPostRequest extends FormRequest
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
            'name' => 'required|max:60|min:5',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
//            'password_confirmation' => 'required|confirmed',
            'referral_code' => '',
            'type_user' => [
                'required',
                Rule::in(['cliente', 'profissional', 'empresa']),
            ],
        ];
    }
}
