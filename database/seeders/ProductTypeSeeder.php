<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productTypes = [
            'Bag',
            'Shoes',
            'Dress',
            'Jacket',
            'Accessories',
            'Shirt',
            'Coat',
            'Swimsuit',
            'Others',
        ];
    
        foreach ($productTypes as $typeName) {
            ProductType::create(['prod_type_name' => $typeName]);
        }
    }
}
