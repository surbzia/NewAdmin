<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteFormRequest extends FormRequest
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
            'name'=>['required','max:255'],
            'email'=>['required','max:255', 'email'],
            'description'=>['max:255'],
            'condition'=>['max:255'],
            'quantity'=>'required',
            'phone'=>['required','max:100'],
        ];
    }
}
