<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
        $has_file = count($request->file()) > 0;
        $id = intval(optional($this->route('user'))->id);
        return [
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:100',
            'email'=>'required|max:255|email|unique:App\Models\User,email'.($id>0?(','.$id):''),
            'role_id'=>'required',
            'password'=>'sometimes|required|max:200',
            'image'=>'sometimes|image|dimensions:min_width=500,min_height=500',
        ];
    }
    public function messages()
    {
        return [
            'image.dimensions' => 'The image file dimensions must be 500x500 ',
        ];
    }
}
