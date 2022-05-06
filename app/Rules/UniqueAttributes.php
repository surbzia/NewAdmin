<?php

namespace App\Rules;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

use Illuminate\Contracts\Validation\Rule;

class UniqueAttributes implements Rule
{
    public $validateRequest;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($validateRequest)
    {
        $this->validateRequest = $validateRequest;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $request  = (object)json_decode($this->validateRequest->data);
        foreach ($request->attributes as $attr) {
            $attribute = ProductAttribute::where('product_id', $request->product_id)->where('attribute', $attr->attribute)->first();
            if($attribute == null){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Attribute already exist for this product.';
    }
}
