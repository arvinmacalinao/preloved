<?php

namespace App\Http\Requests;

use App\Models\ProductType;
use Illuminate\Foundation\Http\FormRequest;

class ProductTypeValidation extends FormRequest
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
            $item = ProductType::find($id);
        }
        return [
			'prod_type_name'           => 'bail|required|string|min:1|max:255|unique:product_types,prod_type_name'.($id > 0 ? ','.$item->prod_type_id.',prod_type_id' : ''),
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
			'prod_type_name'           => 'Product Type Name',
        ];
    }
}
