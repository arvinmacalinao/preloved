<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserValidation extends FormRequest
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
        $item   = NULL;
        if($id > 0) {
            $item = User::find($id);
        }
        return [
			'ug_id'                     => 'bail|required|integer|min:0',
			'u_fname'                   => 'bail|required|string|min:1|max:255',
            'u_mname'                   => 'bail|nullable|string|max:255',
			'u_lname'                   => 'bail|required|string|min:1|max:255',
			'u_email'                   => 'bail|nullable|email|unique:users,u_email'.($id > 0 ? ','.$item->id.',id' : ''),
			'u_mobile'                  => 'bail|nullable|string|max:255',
			'u_username'                => 'bail|nullable|string|max:255|unique:users,u_username'.($id > 0 ? ','.$item->id.',id' : ''),
			'password'                	=> ($id > 0 ? 'bail|sometimes|confirmed|max:255' : 'bail|required|max:255'),
			'password_confirmation'   => 'bail|required_with:password|same:password|max:255',
            'u_enabled'                 => 'bail|nullable|integer',	
			'u_is_superadmin'           => 'bail|nullable|integer',
			'u_is_admin'                => 'bail|nullable|integer',
			'u_is_cashier'              => 'bail|nullable|integer',
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
				'ug_id'                 => 'Usergroup',
				'u_fname'               => 'First Name',
				'u_mname'               => 'Middle Name',
				'u_lname'               => 'Last Name',
				'u_email'               => 'Email Address',
				'u_mobile'              => 'Mobile',
				'u_username'            => 'Username',
				'u_password'            => 'Password',
				'password_confirmation' => 'Password Confirmation',
				'u_enabled'             => 'Account Status',
				'u_is_superadmin'       => 'Is Superadmin',
				'u_is_admin'            => 'Is Store Admin',
				'u_is_cashier'          => 'Is Store Cashier',
			];
		}
}
