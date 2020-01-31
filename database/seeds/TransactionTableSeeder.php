<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'source_identifier' => 'std_A000001',
                'destination_identifier' => null,
                'amount' => 20000.00,

            ],
            [
                'source_identifier' => null,
                'destination_identifier' => 'fuel',
                'amount' => 34000.00,

            ]

        ]);

        //manage fees
        //manage expenses
    }
}
