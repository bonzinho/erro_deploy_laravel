<?php

namespace App\Http\Requests;

use App\Entities\Admin;
use App\Entities\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventCreateRequest extends FormRequest
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

        if($this->type === Client::ROLE && $this->login == 'login'){
            return [
                //'nature_id' => 'required|numeric',
                'denomination' => 'required|max:128',
                'date_time_init' => 'required',
                'doc_program' => 'mimes:pdf,docx,doc|between:1,5000'
                //'support_id'    => 'numeric',
                //'spaces_id' => 'required|numeric',
                //'material_id' => 'numeric',
                //'material_quantity' => 'numeric|min:1',
                //'graphic_id' => 'numeric',
                //'audiovisual_id' => 'numeric',
                //'work_plan' => 'max:256',
                //'technical_raider' => 'max:256',
                //'programme' => 'max:256',
                //'notes' => 'max:256',
            ];
        }

        if($this->type === Client::ROLE && $this->login == 'register'){
            return [
                'selectAccount' => 'required',
                'name' => 'required|max:128',
                'nif'   => 'required|max:13|unique:clients',
                'ac_name' => 'required|max:128',
                'address' => 'required|max:256',
                'postal_code' => 'required|max:10',
                'locality' => 'required|max:18',
                'phone' => 'required|max:13',
                'email' => 'required|unique:clients',
                'password' => 'required|confirmed|min:6',
                'doc_program' => 'mimes:pdf,docx,doc|between:1,5000',
                ########################################
                //'nature_id' => 'required|numeric',
                'denomination' => 'required|max:128',
                'date_time_init' => 'required',
                //'support_id'    => 'numeric',
                //'spaces_id' => 'required|numeric',
                //'material_id' => 'numeric',
                //'material_quantity' => 'numeric|min:1',
                //'graphic_id' => 'numeric',
                //'audiovisual_id' => 'numeric',
                //'work_plan' => 'max:256',
                //'technical_raider' => 'max:256',
                //'programme' => 'max:256',
                //'notes' => 'max:256',
            ];
        }

        if($this->type === Admin::ROLE && auth('admin')->check()){
            ################Admin Autênticado##############
            return [
                //'client_id' => 'required',
                //'nature_id' => 'required|numeric',
                'denomination' => 'required|max:128',
                'doc_program' => 'mimes:pdf,docx,doc|between:1,5000',
                //'date_time_init' => 'required|date',
                //'support_id'    => 'numeric',
                //'spaces_id' => 'required|numeric',
                //'material_id' => 'numeric',
                //'material_quantity' => 'numeric|min:1',
                //'graphic_id' => 'numeric',
                //'audiovisual_id' => 'numeric',
                'work_plan' => 'max:256',
                'technical_raider' => 'max:256',
                'programme' => 'max:256',
                'notes' => 'max:256',
            ];
        }
    }
}
