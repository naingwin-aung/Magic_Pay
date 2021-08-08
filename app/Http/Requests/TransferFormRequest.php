<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferFormRequest extends FormRequest
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
            'to_phone' => ['required','numeric','regex:/^(09|\+?950?9|\+?95950?9)\d{7,9}$/'],
            'amount' => ['required','integer','min:1000', 'max:100000000'],
        ];
    }

    public function messages()
    {
        return [
            'to_phone.required' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ်ထည့်ရန် လိုအပ်သည်။',
            'to_phone.numeric' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ်သည် ဂဏန်းဖြစ်ရမည်။',
            'to_phone.regex' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ်သည် ပြည်တွင်းဖုန်းနံပါတ်ဖြစ်ရမည်။',
            'amount.required' => 'ငွေလွှဲလိုသောပမာဏထည့်ရန် လိုအပ်သည်။',
            'amount.integer' => 'ငွေလွှဲလိုသောပမာဏသည် ဂဏန်းဖြစ်ရမည်။',
            'amount.min' => 'ငွေလွှဲလိုသောပမာဏသည် ၁၀၀၀ကျပ်အထက်ဖြစ်ရမည်။',
            'amount.max' => 'ငွေလွှဲလိုသောပမာဏသည် ၁၀၀၀၀၀၀၀၀ ကျပ်ထက်မပိုရပါ။',
        ];
    }
}
