<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
        $id = intval(optional($this->route('country'))->id);
        return [
            'name'=>'required|max:255',
            'iso_code'=>'required|max:3|unique:App\Models\Country,iso_code'.($id>0?(','.$id):''),
        ];
    }
}
