<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->truncate();
        DB::table('city_infos')->truncate();

        DB::table('cities')->insert([
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city',
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'Buffalo',
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'Albany',
            ],
            [
                'country'=>'USA',
                'state'=>'Alabama',
                'city'=>'Birmingham',
            ],
            [
                'country'=>'USA',
                'state'=>'Alabama',
                'city'=>'Montgomery',
            ],
            [
                'country'=>'USA',
                'state'=>'Alabama',
                'city'=>'Huntsville',
            ],
            [
                'country'=>'Canada',
                'state'=>'Ontario',
                'city'=>'Toronto',
            ],
            [
                'country'=>'Canada',
                'state'=>'Ontario',
                'city'=>'Ottawa',
            ],
            [
                'country'=>'Canada',
                'state'=>'British Columbia',
                'city'=>'Vancouver',
            ],
        ]);

        DB::table('city_infos')->insert([
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city,Rochester,New Rochelle',
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city,Albany,New Rochelle',
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'Buffalo,Albany,Yonkers',
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city,Buffalo,Rochester,New Rochelle',
            ],
            [
                'country'=>'Canada',
                'state'=>'Ontario',
                'city'=>'Toronto,Ottawa',
            ],
        ]);
    }
}
