<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'phone' => ['required','unique:admins,phone','numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
            'password' => 'required|confirmed|min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'အမည်ထည့်ရန် လိုအပ်သည်။',
            'email.required' => 'အီးလ်မေးထည့်ရန် လိုအပ်သည်။',
            'phone.required' => 'ဖုန်းနံပါတ်ထည့်ရန် လိုအပ်သည်။',
            'phone.unique' => 'ဖုန်းနံပါတ် တူညီနေပါသည်။',
            'phone.numeric' => 'ဖုန်းနံပါတ်သည် ဂဏန်းဖြစ်ရမည်။',
            'phone.regex' => 'ပြည်တွင်းဖုန်းနံပါတ် ဖြစ်ရမည်။',
            'password.required' => 'လျှို့ ဝှက်နံပါတ်ထည့်ရန် လိုအပ်သည်။',
            'password.confirmed' => 'လျှို့ ဝှက်နံပါတ် မတူညီပါ။',
            'password.min' => 'လျှို့ ဝှက်နံပါတ်သည်အနည်းဆုံး ၆ လုံးပါဝင်ရမည်။',
            'password.max' => 'လျှို့ ဝှက်နံပါတ်သည်အလုံး ၂၀ ထက်မပိုရပါ။' 
        ];
    }
}
