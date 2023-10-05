<?php

namespace App\Http\Requests;

use App\Models\UserGroup;
use Illuminate\Foundation\Http\FormRequest;

class UserGroupValidation extends FormRequest
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
        $id     = intval($this->route('id'));
        $item   = null;
        if($id > 0) {
            $item = UserGroup::find($id);
        }
        return [
			'ug_name'                   => 'bail|required|string|min:1|max:255|unique:usergroups,ug_name'.($id > 0 ? ','.$item->ug_id.',ug_id' : ''),
			'ug_display_name'           => 'bail|required|string|min:1|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
			'ug_name'                   => 'Usergroup Name',
			'ug_display_name'           => 'Usergroup Display Name'
        ];
    }
}
