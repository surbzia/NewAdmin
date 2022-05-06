<?php

namespace App\Rules;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Contracts\Validation\Rule;

class UniquePartNumWithCondition implements Rule
{
    public $value1;
    public $value2;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($value1,$value2, $id)
    {
        $this->value1 = $value1;
        $this->value2 = $value2;
        $this->id = $id;
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
        $where=[
            'part_number'=> $this->value1,
            'condition' => $this->value2
        ];
        $query = Product::where($where);
        if($this->id>0){
            $query = $query->where('id','<>',$this->id);
        }
        $product = $query->count();
        if($product>0){
        return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Part number already exist with the same condition';
    }
}
