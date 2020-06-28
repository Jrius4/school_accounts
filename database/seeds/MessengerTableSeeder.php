<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class MessengerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $date = Carbon::now();


        for($i=0;$i<300;$i++){
            $y = rand(1,13);
            $x= rand(1,13);
            if($x != $y){
                DB::table('messages')->insert([
                    [
                        'from'=>$x,
                        'to'=>$y,
                        'message'=>$faker->sentence(),
                        'is_read'=>rand(0,1),
                    ]
                ]);
            }

        }

    }
}
