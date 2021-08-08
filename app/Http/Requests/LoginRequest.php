<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone' => ['required','numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'ဖုန်းနံပါတ်ထည့်ရန် လိုအပ်သည်။',
            'phone.numeric' => 'ဖုန်းနံပါတ်သည် ဂဏန်းဖြစ်ရမည်။',
            'phone.regex' => 'ပြည်တွင်းဖုန်းနံပါတ် ဖြစ်ရမည်။',
            'password.required' => 'လျှို့ ဝှက်နံပါတ်ထည့်ရန် လိုအပ်သည်။',
        ];
    }
}
