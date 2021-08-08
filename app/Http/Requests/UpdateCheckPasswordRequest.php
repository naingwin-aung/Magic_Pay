<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCheckPasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'လက်ရှိလျှို့ ဝှက်နံပါတ်ထည့်ရန် လိုအပ်သည်။',
            'password.required' => 'လျှို့ ဝှက်နံပါတ်အသစ်ထည့်ရန် လိုအပ်သည်။',
            'password.confirmed' => 'လျှို့ ဝှက်နံပါတ် မတူညီပါ။',
            'password.min' => 'လျှို့ ဝှက်နံပါတ်အသစ်သည်အနည်းဆုံး ၆ လုံးပါဝင်ရမည်။',
            'password.max' => 'လျှို့ ဝှက်နံပါတ်အသစ်သည်အလုံး ၂၀ ထက်မပိုရပါ။' 
        ];
    }
}
