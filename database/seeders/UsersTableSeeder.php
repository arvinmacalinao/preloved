<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'u_fname' => 'admin',
            'u_mname' => 'a',
            'u_lname' => 'admin',
            'u_username' => 'admin',
            'u_email' => 'admin@admin.com',
            'u_mobile' => '09123456789',
            'password' => Hash::make('123456'),
            'ug_id' => 1,
            'u_enabled' => 1,
            'u_is_superadmin' => 1,
            'u_is_owner' => 1,
            'u_is_owner' => 1,
            'u_is_store_manager' => 1,
            'u_is_admin' => 1,
            'synched' => 0,
            'sync_date' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
