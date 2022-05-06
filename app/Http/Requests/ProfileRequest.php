<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
        $user_id = Auth::user()->id;
        return [
            'email'=>'required|email|max:255|unique:App\Models\User,email'.($user_id>0?(','.$user_id):''),
            'password'=>'sometimes|required|max:200|min:5',
            'file'=>'sometimes|required|image',
        ];
    }
}
