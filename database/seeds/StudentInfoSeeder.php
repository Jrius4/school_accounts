<?php

use App\Models\Student;
use App\Subject;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        $date =new Carbon();

        DB::table('students')->insert([
            //Alevel
            [
                'name'=>'Kazibwe Julia',
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',1),
                'password'=>bcrypt('student'),
                "schclass_id"=>"6",
                'schstream_id'=>"7",
                'combination_id'=>"1",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Kazibwe Julia',"_")."_picture.JPG",
                'medical_form'=>str_slug('Kazibwe Julia',"_")."_medical.pdf",
                'admission_form'=>str_slug('Kazibwe Julia',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Micheal Kato',
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',2),
                'password'=>bcrypt('student'),
                "schclass_id"=>"6",
                'schstream_id'=>"9",
                'combination_id'=>"2",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Micheal Kato',"_")."_picture.JPG",
                'medical_form'=>str_slug('Micheal Kato',"_")."_medical.pdf",
                'admission_form'=>str_slug('Micheal Kato',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Nakiwala Anita',
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',3),
                'password'=>bcrypt('student'),
                "schclass_id"=>"5",
                'schstream_id'=>"8",
                'combination_id'=>"1",
                'gender'=>"female",
                'amount_paid'=>"600000",
                'image'=>str_slug('Nakiwala Anita',"_")."_picture.JPG",
                'medical_form'=>str_slug('Nakiwala Anita',"_")."_medical.pdf",
                'admission_form'=>str_slug('Nakiwala Anita',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>"Sheila Evenlyn",
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',8),
                'password'=>bcrypt('student'),
                "schclass_id"=>"5",
                'schstream_id'=>"8",
                'combination_id'=>"1",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug("Sheila Evenlyn","_")."_picture.JPG",
                'medical_form'=>str_slug("Sheila Evenlyn","_")."_medical.pdf",
                'admission_form'=>str_slug("Sheila Evenlyn","_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Kiseka Marvin',
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',4),
                'password'=>bcrypt('student'),
                "schclass_id"=>"6",
                'schstream_id'=>"7",
                'combination_id'=>"2",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Kiseka Marvin',"_")."_picture.JPG",
                'medical_form'=>str_slug('Kiseka Marvin',"_")."_medical.pdf",
                'admission_form'=>str_slug('Kiseka Marvin',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Kamya Moses',
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',5),
                'password'=>bcrypt('student'),
                "schclass_id"=>"6",
                'schstream_id'=>"7",
                'combination_id'=>"1",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Kamya Moses',"_")."_picture.JPG",
                'medical_form'=>str_slug('Kamya Moses',"_")."_medical.pdf",
                'admission_form'=>str_slug('Kamya Moses',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Kaweke Henry',
                'roll_number'=>'A/'.date('Y').'/'.sprintf('%03s',6),
                'password'=>bcrypt('student'),
                "schclass_id"=>"5",
                'schstream_id'=>"9",
                'combination_id'=>"1",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Kaweke Henry',"_")."_picture.JPG",
                'medical_form'=>str_slug('Kaweke Henry',"_")."_medical.pdf",
                'admission_form'=>str_slug('Kaweke Henry',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            //Olevel
            [
                'name'=>'Johnson Kaggwa',
                'roll_number'=>'O/'.date('Y').'/'.sprintf('%03s',5),
                'password'=>bcrypt('student'),
                "schclass_id"=>"4",
                'schstream_id'=>"4",
                'combination_id'=>"1",
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Johnson Kaggwa',"_")."_picture.JPG",
                'medical_form'=>str_slug('Johnson Kaggwa',"_")."_medical.pdf",
                'admission_form'=>str_slug('Johnson Kaggwa',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Junior Candidate',
                'roll_number'=>'O/'.date('Y').'/'.sprintf('%03s',6),
                'password'=>bcrypt('student'),
                "schclass_id"=>"4",
                'schstream_id'=>"3",
                'combination_id'=>null,
                'gender'=>"male",
                'amount_paid'=>"400000",
                'image'=>str_slug('Junior Candidate',"_")."_picture.JPG",
                'medical_form'=>str_slug('Junior Candidate',"_")."_medical.pdf",
                'admission_form'=>str_slug('Junior Candidate',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>"Ojok Isaac",
                'roll_number'=>'O/'.date('Y').'/'.sprintf('%03s',10),
                'password'=>bcrypt('student'),
                "schclass_id"=>"3",
                'schstream_id'=>"5",
                'combination_id'=>null,
                'gender'=>"male",
                'amount_paid'=>"250000",
                'image'=>str_slug("Ojok Isaac","_")."_picture.JPG",
                'medical_form'=>str_slug("Ojok Isaac","_")."_medical.pdf",
                'admission_form'=>str_slug("Ojok Isaac","_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Resty Moreen',
                'roll_number'=>'O/'.date('Y').'/'.sprintf('%03s',8),
                'password'=>bcrypt('student'),
                "schclass_id"=>"2",
                'schstream_id'=>"3",
                'combination_id'=>null,
                'gender'=>"female",
                'amount_paid'=>"250000",
                'image'=>str_slug('Resty Moreen',"_")."_picture.JPG",
                'medical_form'=>str_slug('Resty Moreen',"_")."_medical.pdf",
                'admission_form'=>str_slug('Resty Moreen',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
            [
                'name'=>'Juuko Heneky',
                'roll_number'=>'O/'.date('Y').'/'.sprintf('%03s',4),
                'password'=>bcrypt('student'),
                "schclass_id"=>"1",
                'schstream_id'=>"4",
                'combination_id'=>null,
                'gender'=>"male",
                'amount_paid'=>"600000",
                'image'=>str_slug('Juuko Heneky',"_")."_picture.JPG",
                'medical_form'=>str_slug('Juuko Heneky',"_")."_medical.pdf",
                'admission_form'=>str_slug('Juuko Heneky',"_")."_admission.pdf",
                'created_at'=>$date->now(),
                'updated_at'=>$date->now(),
            ],
        ]);

        Student::find(9)->subjects()->attach(Subject::find([10,7]));
    }
}
