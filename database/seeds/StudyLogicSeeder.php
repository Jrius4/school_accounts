<?php

use App\Result;
use App\Schclass;
use App\Schstream;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class StudyLogicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('schclasses')->delete();
        DB::table('schstreams')->delete();


        Schstream::create(['name'=>'Dragon Fire','slug' => str_slug('Dragon Fire')]);
        Schstream::create(['name'=>'Speed Star','slug' => str_slug('Speed Star')]);
        Schstream::create(['name'=>'Kangaroo','slug' => str_slug('Kangaroo')]);
        Schstream::create(['name'=>'Snakes','slug' => str_slug('Snakes')]);
        Schstream::create(['name'=>'Arrows','slug' => str_slug('Arrows')]);
        Schstream::create(['name'=>'The Runneraway','slug' => str_slug('The Runneraway')]);
        Schstream::create(['name'=>'Physical','slug' => str_slug('Physical')]);
        Schstream::create(['name'=>'Biology','slug' => str_slug('Biology')]);
        Schstream::create(['name'=>'Arts','slug' => str_slug('Arts')]);



        Schclass::create(['name'=>'Senior One','slug' => str_slug('Senior One'),'level'=>"Ordinary Level"])->classStreames()->attach(Schstream::find([1,2]));
        Schclass::create(['name'=>'Senior Two','slug' => str_slug('Senior Two'),'level'=>"Ordinary Level"])->classStreames()->attach(Schstream::find([1,2]));
        Schclass::create(['name'=>'Senior Three','slug' => str_slug('Senior Three'),'level'=>"Ordinary Level"])->classStreames()->attach(Schstream::find([3,4]));
        Schclass::create(['name'=>'Senior Four','slug' => str_slug('Senior Four'),'level'=>"Ordinary Level"])->classStreames()->attach(Schstream::find([5,6]));
        Schclass::create(['name'=>'Senior Five','slug' => str_slug('Senior Five'),'level'=>"Advanced Level"])->classStreames()->attach(Schstream::find([7,8,9]));
        Schclass::create(['name'=>'Senior Six','slug' => str_slug('Senior Six'),'level'=>"Advanced Level"])->classStreames()->attach(Schstream::find([7,8,9]));






    }
}
