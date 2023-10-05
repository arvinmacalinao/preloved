<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gender = [
            'gender_name' => 'Male',
        ];
        
        // Insert the data into the "user_groups" table
        DB::table('genders')->insert($gender);
    }
}
