<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'denomination' => 'required|max:128',
            'doc_program' => 'mimes:pdf,docx,doc|between:1,5000',
            'work_plan' => 'max:256',
            'technical_raider' => 'max:256',
            'programme' => 'max:256',
            'notes' => 'max:256',
        ];
    }
}
