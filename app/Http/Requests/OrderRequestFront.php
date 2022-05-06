<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequestFront extends FormRequest
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
            'shipping_email'=>'email|required|max:255',
            'shipping_notes'=>'max:555',
            'shipping_first_name'=>'required|max:100',
            'shipping_last_name'=>'required|max:100',
            'shipping_address'=>'required|max:255',
            'shipping_city'=>'required|max:100',
            'shipping_state'=>'required|max:100',
            'shipping_country'=>'required|max:255',
            'shipping_company'=>'max:255',
            'shipping_zip'=>'required|max:20',
            'shipping_phone'=>'required|max:100',

            'billing_email'=>'email|required|max:255',
            'billing_first_name'=>'required|max:100',
            'billing_last_name'=>'required|max:100',
            'billing_address'=>'required|max:255',
            'billing_city'=>'required|max:100',
            'billing_state'=>'required|max:100',
            'billing_country'=>'required|max:255',
            'billing_company'=>'max:255',
            'billing_zipcode'=>'required|max:20',
            'billing_phone'=>'required|max:100',
            'card.number'=>'required',
            'card.month'=>'required',
            'card.year'=>'required',
            'card.cvv'=>'required',
        ];
    }
}
