<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductValidation extends FormRequest
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
            $item = Product::find($id);
        }
        return [
			'prod_description'       => 'bail|required|string|min:1|max:255',
            'prod_price'             => 'bail|required',
            'prod_quantity'          => 'bail|required',
            'prod_type_id'           => 'bail|required',
            'prod_owner_id'          => 'bail|required'
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
			'prod_description'      => 'Product Description',       
            'prod_price'            => 'Product Price',
            'prod_quantity'         => 'Product Quantity',
            'prod_type_id'          => 'Product Type',
            'prod_owner_id'         => 'Product Owner'

        ];
    }
}
