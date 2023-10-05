<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prodOwner = [
        [
            'prod_owner_name'   =>  'Arvin Macalinao', 
            'prod_owner_email'  =>  'arvin.macalinao@cherry.com.ph', 
            'prod_owner_phone'  =>  '09271455040', 
            'created_at'        =>  now(), 
            'updated_at'        =>  now(), 
            'deleted_at'        =>  null, 
            'created_by'        =>  1, 
            'updated_by'        =>  1, 
            'deleted_by'        =>  null,
        ],
        [
            'prod_owner_name'   =>  'IT', 
            'prod_owner_email'  =>  'itdept@cherrymoble.com.ph', 
            'prod_owner_phone'  =>  '09123456789', 
            'created_at'        =>  now(), 
            'updated_at'        =>  now(), 
            'deleted_at'        =>  null, 
            'created_by'        =>  1, 
            'updated_by'        =>  1, 
            'deleted_by'        =>  null,
        ]
        ];

        DB::table('product_owners')->insert($prodOwner);
    }
}
