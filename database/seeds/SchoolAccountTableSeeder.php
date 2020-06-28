<?php

use App\AccCategory;
use App\Accounts\SchoolAccount;
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
        $accType = new AccCategory();
        $acc = new SchoolAccount();

        $accType->create(
            array(
                'name'=>'Main Account',
                'slug'=>str_slug('Main Account')
            )
        );
        $accType->create(
            array(
                'name'=>'Loans',
                'slug'=>str_slug('Loans')
            )
        );
        $accType->create(
            array(
                'name'=>'Student',
                'slug'=>str_slug('Student')
            )
        );
        $accType->create(
            array(
                'name'=>'Welfare',
                'slug'=>str_slug('Welfare')
            )
        );
        $accType->create(
            array(
                'name'=>'School Assets',
                'slug'=>str_slug('School Assets')
            )
        );

        $acc->create(
            array(
                'account_name'=>'Main Account',
                'account_slug'=>str_slug('Main Account'),
                'acc_category_id'=>$accType->whereName('Main Account')->first()->id,
                'amount'=>60000.00
            )
        );

        $acc->create(
            array(
                'account_name'=>'Construction Loan',
                'account_slug'=>str_slug('Construction Loan'),
                'amount'=>450080000.00,
                'acc_category_id'=>$accType->whereName('Loans')->first()->id,
            )
        );

        $acc->create(
            array(
                'account_name'=>'School Fees',
                'account_slug'=>str_slug('School Fees'),
                'amount'=>450080000.00,
                'acc_category_id'=>$accType->whereName('Student')->first()->id,
            )
        );

        $acc->create(
            array(
                'account_name'=>'Development Fees',
                'account_slug'=>str_slug('Development Fees'),
                'acc_category_id'=>$accType->whereName('School Assets')->first()->id,
                'amount'=>8080000.00,
                'to_pay'=>50000,
            )
        );

        $acc->create(
            array(
                'account_name'=>'Sports',
                'account_slug'=>str_slug('Sports'),
                'acc_category_id'=>$accType->whereName('Student')->first()->id,
                'amount'=>75000.00,
                'to_pay'=>30000
            )
        );

        $acc->create(
            array(
                'account_name'=>'Building Block C',
                'account_slug'=>str_slug('Building Block C'),
                'acc_category_id'=>$accType->whereName('Student')->first()->id,
                'amount'=>350000.00,
                'set_minium_balance'=>550000,
            )
        );

    }
}
