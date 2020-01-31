<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Term;

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
                'grade'=>'15',
            ],
            [
                'set_name'=>'Mid Of Term',
                'grade'=>'35',
            ],
            [
                'set_name'=>'End Of Term',
                'grade'=>'60',
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

        DB::table('results')->insert([
            [
                'user_id'=>'9',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'1',
                'paper_id'=>'1',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>'78',
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>'2019',
            ],
            [
                'user_id'=>'3',
                'student_id'=>'3',
                'schclass_id'=>'5',
                'subject_id'=>'5',
                'paper_id'=>'5',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>'78',
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>'2019',
            ],
            [
                'user_id'=>'12',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'4',
                'paper_id'=>'1',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>'78',
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>'2019',
            ],
            [
                'user_id'=>'9',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'1',
                'paper_id'=>'3',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>'78',
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>'2019',
            ],
            [
                'user_id'=>'9',
                'student_id'=>'8',
                'schclass_id'=>'4',
                'subject_id'=>'1',
                'paper_id'=>'2',
                'exmset_id'=>'1',
                'term_id'=>'1',
                'mark'=>'78',
                'grade'=>'D2',
                'comments'=>'Nice try hard work more',
                'year'=>'2019',
            ],
        ]);
    }
}
