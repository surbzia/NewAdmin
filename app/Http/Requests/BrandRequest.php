<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        $id = intval(optional($this->route('brand'))->id);
        return [
            'name'=>'required|max:255',
            'slug'=>'required|max:255|unique:App\Models\Brand,slug'.($id>0?(','.$id):''),
        ];
    }
}
