<?php

namespace App\Http\Requests;

use App\Rules\UniquePartNumWithCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VariantRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $id = intval(optional($this->route('variants.update'))->id);
        return [
            // 'sku'=>'required|max:255|unique:App\Models\Variant,sku'.($id>0?(','.$id):''),
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions' => 'The Image must be at least 455 x 436 pixels!',
        ];
    }
}
