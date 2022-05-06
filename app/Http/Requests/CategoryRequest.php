<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $id = intval(optional($this->route('category'))->id);
        return [
            'name'=>'required|max:255',
            'slug'=>'required|max:255|unique:App\Models\Category,slug'.($id>0?(','.$id):''),
            'category_alias'=>'required|max:255',
        ];
    }
}
