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
            'title'=>'school tour',
            'detail'=>'school tour',
            'start'=>$date->parse('2020-07-15 19:38:55')->modify('+1 days'),
            'end'=>$date->parse('2020-07-15 19:38:55')->modify('+3 days'),
            'user_id'=>8,
        ]);

        Task::create([
            'title'=>'PTA',
            'detail'=>'academics',
            'start'=>$date->parse('2020-07-15 19:38:55')->modify('-15 days'),
            'end'=>$date->parse('2020-07-15 19:38:55')->modify('-15 days'),
            'user_id'=>8,
        ]);

        Task::create([
            'title'=>'school tour',
            'detail'=>'school tour',
            'start'=>$date->parse('2020-07-15 19:38:55')->modify('+13 days'),
            'end'=>$date->parse('2020-07-15 19:38:55')->modify('+16 days'),
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
