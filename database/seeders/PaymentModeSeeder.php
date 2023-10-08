<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentmode = [
        [
            'payment_mode_name' => 'Cash',
        ],
        [
            'payment_mode_name' => 'Credit Card',
        ],
        [
            'payment_mode_name' => 'Digital/Mobile Wallet',
        ],
        [
            'payment_mode_name' => 'Gcash',
        ],
        [
            'payment_mode_name' => 'Paymaya',
        ],
        [
            'payment_mode_name' => 'Bank Transfers',
        ],
        [
            'payment_mode_name' => 'Direct Debit',
        ],
        
    ];
        
        // Insert the data into the "user_groups" table
        DB::table('payment_modes')->insert($paymentmode);
    }
}
