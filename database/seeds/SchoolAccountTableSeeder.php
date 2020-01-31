<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SchoolAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_accounts')->insert([
            [
                'account_name' => 'school_account',
                'amount' => 60000.00,

            ]

        ]);
    }
}
