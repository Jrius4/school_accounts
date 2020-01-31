<?php

use App\Exmset;
use App\Schclass;
use App\Subject;
use App\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   DB::table('subjects')->delete();
        $array = range(1,Schclass::count());
        $o_lvl = array_slice($array,0,-2);
        $a_lvl = array_slice($array,0,-2);
        $subjects = new Subject();
        Subject::create(['name'=>'Ordinary Biology']);

        $subjects->whereName('Ordinary Biology')->first()->schoolClasses()->detach($o_lvl);
        $subjects->whereName('Ordinary Biology')->first()->schoolClasses()->attach($o_lvl);

        Subject::create(['name'=>'Advanced Biology'])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Advanced Physics'])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Ordinary Physics'])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'English'])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'General Paper'])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Ordinary Literature'])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Technical Drawing'])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Advanced Literature'])->schoolClasses()->attach($a_lvl);




    }


}
