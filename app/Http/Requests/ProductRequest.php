<?php

namespace App\Http\Requests;

use App\Rules\UniquePartNumWithCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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

        $id = intval(optional($this->route('product'))->id);
        return [
            'name'=>'required|max:255',
            'slug'=>'required|max:300|unique:App\Models\Product,slug'.($id>0?(','.$id):''),
            'price'=>'required',
            'has_variant'=>'required',
            'sale_price'=>'required',
            'description'=>'required',
            'image'=>'image|dimensions:min_width=455,min_height=436',
            'related_products'=>'sometimes|array',
            'category_id'=>'required|exists:App\Models\Category,id',
            'brand_id'=>'required|exists:App\Models\Brand,id',
            'in_stock'=>[Rule::in([0,1])],
            'manage_stock'=>[Rule::in([0,1])],
            'stock_qty'=>'sometimes|integer|min:1',
            'sku'=>'required|max:255|unique:App\Models\Product,sku'.($id>0?(','.$id):''),
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions' => 'The Image must be at least 455 x 436 pixels!',
        ];
    }
}
