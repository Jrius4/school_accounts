<?php

use Carbon\Carbon;
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
        $date = new Carbon();
        DB::table('cities')->truncate();
        DB::table('city_infos')->truncate();

        DB::table('cities')->insert([
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'Buffalo',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'Albany',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'Alabama',
                'city'=>'Birmingham',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'Alabama',
                'city'=>'Montgomery',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'Alabama',
                'city'=>'Huntsville',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'Canada',
                'state'=>'Ontario',
                'city'=>'Toronto',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'Canada',
                'state'=>'Ontario',
                'city'=>'Ottawa',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'Canada',
                'state'=>'British Columbia',
                'city'=>'Vancouver',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
        ]);

        DB::table('city_infos')->insert([
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city,Rochester,New Rochelle',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city,Albany,New Rochelle',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'Buffalo,Albany,Yonkers',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'USA',
                'state'=>'New York',
                'city'=>'New York city,Buffalo,Rochester,New Rochelle',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
            [
                'country'=>'Canada',
                'state'=>'Ontario',
                'city'=>'Toronto,Ottawa',
                'created_at'=>$date->now(),
                'updated_at'=>$date->now()
            ],
        ]);
    }
}
