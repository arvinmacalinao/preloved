<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userGroup = [
            [
            'ug_name' => 'Management Information System',
            'ug_is_admin' => 1,
            'ug_display_name' => 'MIS',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ],
        [
            'ug_name' => 'SM',
            'ug_is_admin' => 0,
            'ug_display_name' => 'Store Manager',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]
        ];

        // Insert the data into the "user_groups" table
        DB::table('usergroups')->insert($userGroup);
    }
}
