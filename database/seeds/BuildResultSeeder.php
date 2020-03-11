<?php

use App\Exmset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Term;
use Carbon\Carbon;

class BuildResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Term::create(
            ['name'=>'Term One']
        );
        Term::create(
            ['name'=>'Term Two']
        );
        Term::create(
            ['name'=>'Term Three']
        );

        DB::table('exmsets')->insert([
            [
                'set_name'=>'Beginning Of Term',
                'set_percentage'=>'15',
            ],
            [
                'set_name'=>'Mid Of Term',
                'set_percentage'=>'25',
            ],
            [
                'set_name'=>'End Of Term',
                'set_percentage'=>'60',
            ],
        ]);
        //roadmap
        //create papers
        DB::table('papers')->insert([
            [
                'subject_id'=>'8',
                'paper_name'=>'Geometrical Drawing',
                'paper_abbrev'=>'P1',
            ],
            [
                'subject_id'=>'8',
                'paper_name'=>'Building Construction',
                'paper_abbrev'=>'P2',
            ],
            [
                'subject_id'=>'1',
                'paper_name'=>null,
                'paper_abbrev'=>'P1',
            ],
            [
                'subject_id'=>'1',
                'paper_name'=>null,
                'paper_abbrev'=>'P2',
            ],
            [
                'subject_id'=>'4',
                'paper_name'=>null,
                'paper_abbrev'=>'P1',
            ],
            [
                'subject_id'=>'4',
                'paper_name'=>null,
                'paper_abbrev'=>'P2',
            ],
            [
                'subject_id'=>'4',
                'paper_name'=>null,
                'paper_abbrev'=>'P3',
            ],
            [
                'subject_id'=>'14',
                'paper_name'=>null,
                'paper_abbrev'=>'P1',
            ],
            [
                'subject_id'=>'14',
                'paper_name'=>null,
                'paper_abbrev'=>'P2',
            ],
            [
                'subject_id'=>'14',
                'paper_name'=>null,
                'paper_abbrev'=>'P3',
            ],
        ]);
        //set papers
        DB::table('setpps')->insert([
            [
                'paper_id'=>'1',
                'subject_id'=>'8',
                'percentage'=>'50',
            ],
            [
                'paper_id'=>'2',
                'subject_id'=>'8',
                'percentage'=>'50',
            ],
            [
                'paper_id'=>'3',
                'subject_id'=>'1',
                'percentage'=>'30',
            ],
            [
                'paper_id'=>'4',
                'subject_id'=>'1',
                'percentage'=>'30',
            ],
            [
                'paper_id'=>'4',
                'subject_id'=>'1',
                'percentage'=>'40',
            ],

        ]);


        //create marks or results
        $date = new Carbon();

        DB::table('results')->insert([
            [
                'user_id'=>'9',
                'student_id'=>'4',
                'schclass_id'=>'5',
                'subject_id'=>'14',
                'paper_id'=>'8',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>80,
                'calculate_mark'=>80*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
            [
                'user_id'=>'9',
                'student_id'=>'4',
                'schclass_id'=>'5',
                'subject_id'=>'14',
                'paper_id'=>'9',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>95,
                'calculate_mark'=>95*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
            [
                'user_id'=>'9',
                'student_id'=>'4',
                'schclass_id'=>'5',
                'subject_id'=>'14',
                'paper_id'=>'10',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>78,
                'calculate_mark'=>78*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
            [
                'user_id'=>'3',
                'student_id'=>'1',
                'schclass_id'=>'6',
                'subject_id'=>'6',
                'paper_id'=>null,
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>65,
                'calculate_mark'=>65*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
            [
                'user_id'=>'12',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'4',
                'paper_id'=>'5',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>85,
                'calculate_mark'=>85*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
            [
                'user_id'=>'9',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'1',
                'paper_id'=>'3',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>90,
                'calculate_mark'=>90*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
            [
                'user_id'=>'9',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'1',
                'paper_id'=>'2',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>55,
                'calculate_mark'=>55*(Exmset::find('1')->set_percentage/100),
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>date('Y'),
                'created_at'=> $date->now(),
                'updated_at'=> $date->now(),
            ],
        ]);
    }
}
