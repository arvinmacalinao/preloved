<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProductOwnerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UserGroupSeeder::class]);
        $this->call([UsersTableSeeder::class]);
        $this->call([GenderSeeder::class]);
        $this->call([ProductTypeSeeder::class]);
        // $this->call([ProductOwnerSeeder::class]);
        $this->call([PaymentModeSeeder::class]);
        
    }
}
