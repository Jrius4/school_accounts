<?php

use App\Blog;
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

        for ($i=1; $i < 20; $i++) {
            Blog::create([
                'code'=>$i%14,
                'name'=>$faker->sentence(),
            ]);
        }
        
    }
}
