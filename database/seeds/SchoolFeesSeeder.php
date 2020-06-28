<?php

use App\ClassFee;
use Illuminate\Database\Seeder;

class SchoolFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassFee::create(array(
            'schclass_id'=>1,
            'fees_amount'=>'350000'
        ));

        ClassFee::create(array(
            'schclass_id'=>2,
            'fees_amount'=>'350000'
        ));

        ClassFee::create(array(
            'schclass_id'=>3,
            'fees_amount'=>'450000'
        ));

        ClassFee::create(array(
            'schclass_id'=>4,
            'fees_amount'=>'550000'
        ));

        ClassFee::create(array(
            'schclass_id'=>5,
            'fees_amount'=>'650000'
        ));

        ClassFee::create(array(
            'schclass_id'=>6,
            'fees_amount'=>'750000'
        ));
    }
}
