<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserChangeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'new_name' => 'required|min:3',
            'new_surname' => 'required|string|min:3',
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
        ];
    }
}
