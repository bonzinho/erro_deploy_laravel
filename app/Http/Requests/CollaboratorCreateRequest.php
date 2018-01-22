<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollaboratorCreateRequest extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'student_number' => 'max:18',
            'genre' => 'required',
            'type' => 'required|integer',
            'email' => 'required|e-mail|unique:collaborators,email',
            'address' => 'required|max:255',
            'postal_code' => 'required|max:8',
            'locality' => 'required|max:60',
            'nif' => 'required|max:12',
            'phone' => 'required|max:9',
            'cc' => 'required|max:15',
            'iban' => 'required|max:20',
            'cv' => 'mimes:pdf,docx,doc|between:1,3000',
            'photo' => 'required|mimes:jpg,jpeg,png|between:1,3000',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
    }
}
