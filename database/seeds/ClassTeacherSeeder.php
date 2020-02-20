<?php

use App\Schclass;
use Illuminate\Database\Seeder;

class ClassTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = new Schclass();
        $class->findOrFail(1)->update(['user_id'=>5]);
        $class->findOrFail(3)->update(['user_id'=>9]);
        $class->findOrFail(4)->update(['user_id'=>12]);
        $class->findOrFail(5)->update(['user_id'=>12]);
    }
}
