<?php

use App\Blog;
use App\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $date = new Carbon();
        Task::create([
            'name'=>'school tour',
            'details'=>'school tour',
            'start'=>$date->parse('2020-07-15')->modify('+1 days')->format('Y-m-d'),
            'end'=>$date->parse('2020-07-15')->modify('+3 days')->format('Y-m-d'),
            'user_id'=>8,
        ]);

        Task::create([
            'name'=>'PTA',
            'details'=>'academics',
            'start'=>$date->parse('2020-07-15')->modify('-15 days')->format('Y-m-d'),
            'end'=>$date->parse('2020-07-15')->modify('-15 days')->format('Y-m-d'),
            'user_id'=>8,
        ]);

        Task::create([
            'name'=>'school tour',
            'details'=>'school tour',
            'start'=>$date->parse('2020-07-15')->modify('+13 days')->format('Y-m-d'),
            'end'=>$date->parse('2020-07-15')->modify('+16 days')->format('Y-m-d'),
            'user_id'=>8,
        ]);

        for ($i=1; $i < 20; $i++) {
            Blog::create([
                'code'=>$i%14,
                'name'=>$faker->sentence(),
            ]);
        }

    }
}
