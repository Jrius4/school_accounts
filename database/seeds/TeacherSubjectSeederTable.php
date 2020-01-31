<?php

use App\Role;
use App\Subject;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TeacherSubjectSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = Role::whereName('teacher')->first();
        $subject1 = Subject::whereName('Advanced Physics')->first();
        $subject2 = Subject::whereName('Ordinary Physics')->first();
        $subject3 = Subject::whereName('Ordinary Biology')->first();
        User::create([
            'name'=>'Magezi Peter',
            'username'=>'magezi',
            'slug'=>'magezi',
            'password'=>'123456',
            'remember_token'=>Str::random(10)
            ]);
        $user = new User();
        $user->whereName('Magezi Peter')->first()->roles()->detach($teacher);
        $user->whereName('Magezi Peter')->first()->roles()->attach($teacher);

        $user->whereName('Magezi Peter')->first()->subjects()->detach([$subject1->id,$subject2->id,$subject3->id]);
        $user->whereName('Magezi Peter')->first()->subjects()->attach([$subject1->id,$subject2->id,$subject3->id]);

        // $user->whereName('Magezi Peter')->first()->subjects()->detach($teacher);
        // $user->whereName('Magezi Peter')->first()->subjects()->attach($teacher);

        // $user->whereName('Magezi Peter')->first()->subjects()->detach($teacher);
        // $user->whereName('Magezi Peter')->first()->subjects()->attach($teacher);

        // $user->whereName('Magezi Peter')->first()->subjects()->detach($teacher);
        // $user->whereName('Magezi Peter')->first()->subjects()->attach($teacher);
    }
}
