<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductQuoteRequest extends FormRequest
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
            'email'=>'required|email|max:255',
            'qty'=>'required|integer|min:1',
            'product_id'=>'required|exists:App\Models\Product,id',
        ];
    }
}
