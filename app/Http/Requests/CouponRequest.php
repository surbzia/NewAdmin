<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        $id = intval(optional($this->route('coupon'))->id);
        return [
            'name'=>'required|max:255',
            'code'=>'required|max:255|unique:App\Models\Coupon,code'.($id>0?(','.$id):''),
            'discount_type'=>'required',
            'discount'=>'required',
        ];
    }
}
