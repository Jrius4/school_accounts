<?php

use App\Combination;
use App\Schclass;
use App\Subject;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->delete();
        DB::table('combinations')->delete();
        $array = range(1,Schclass::count());
        $o_lvl = array_slice($array,0,-2);
        $a_lvl = array_slice($array,0,-2);
        $subjects = new Subject();
        Subject::create(['name'=>'Ordinary Biology','level'=>'Ordinary Level','subject_code'=>'O-Bio','subject_compulsory'=>true]);

        $subjects->whereName('Ordinary Biology')->first()->schoolClasses()->detach($o_lvl);
        $subjects->whereName('Ordinary Biology')->first()->schoolClasses()->attach($o_lvl);

        Subject::create(['name'=>'Advanced Biology','level'=>'Advanced Level','subject_code'=>'A-Bio','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Advanced Physics','level'=>'Advanced Level','subject_code'=>'A-Phy','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Ordinary Physics','level'=>'Ordinary Level','subject_code'=>'O-Phy','subject_compulsory'=>true])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'English','level'=>'Ordinary Level','subject_code'=>'O-Eng','subject_compulsory'=>true])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'General Paper','level'=>'Advanced Level','subject_code'=>'A-GP','subject_compulsory'=>true])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Ordinary Literature','level'=>'Ordinary Level','subject_code'=>'O-Lit','subject_compulsory'=>false])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Technical Drawing','level'=>'Ordinary Level','subject_code'=>'O-TD','subject_compulsory'=>false])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Ordinary Commerce','level'=>'Ordinary Level','subject_code'=>'O-Commer','subject_compulsory'=>false])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Additional Math','level'=>'Ordinary Level','subject_code'=>'O-Addit','subject_compulsory'=>false])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Ordinary Agriculture','level'=>'Ordinary Level','subject_code'=>'O-Agric','subject_compulsory'=>false])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Fine Art','level'=>'Ordinary Level','subject_code'=>'O-Art','subject_compulsory'=>false])->schoolClasses()->attach($o_lvl);
        Subject::create(['name'=>'Advanced Geography','level'=>'Advanced Level','subject_code'=>'A-Geog','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Advanced Chemistry','level'=>'Advanced Level','subject_code'=>'A-Chem','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Advanced Fine Art','level'=>'Advanced Level','subject_code'=>'A-FA','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Advanced Literature','level'=>'Advanced Level','subject_code'=>'A-Lit','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);
        Subject::create(['name'=>'Advanced Mathematics','level'=>'Advanced Level','subject_code'=>'A-Math','subject_compulsory'=>false])->schoolClasses()->attach($a_lvl);

        //combinations
        Combination::create(['level'=>'Advanced Level','first_subject'=>'Advanced Physics','second_subject'=>'Advanced Biology','third_subject'=>'Advanced Chemistry','subsidiary'=>'Sub Math','combination_name'=>'PCB']);
        Combination::create(['level'=>'Advanced Level','first_subject'=>'Advanced Physics','second_subject'=>'Advanced Chemistry','third_subject'=>'Advanced Mathematics','subsidiary'=>'Sub ICT','combination_name'=>'PCM']);


    }
}
