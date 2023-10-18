<?php

namespace App\Http\Requests;

use App\Models\ProductOwner;
use Illuminate\Foundation\Http\FormRequest;

class ProductOwnerValidation extends FormRequest
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
    
    public function rules()
    {
        $id     = intval($this->route('id'));
        $item   = null;
        if($id > 0) {
            $item = ProductOwner::find($id);
        }
        return [
			'prod_owner_name'        => 'bail|required|string|min:1|max:255|unique:product_owners,prod_owner_email'.($id > 0 ? ','.$item->prod_owner_id.',prod_owner_id' : ''),
            'prod_owner_email'       => 'bail|nullable|email|',
            'prod_owner_phone'       => 'bail|nullable|string|min:1|max:255|'
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
			'prod_owner_name'             => 'Owner Name',
			'prod_owner_email'            => 'Owner Email',
			'prod_owner_phone'            => 'Owner Phone No',
        ];
    }
}
