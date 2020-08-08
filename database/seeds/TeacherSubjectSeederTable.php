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
            'last_name' => 'Magezi',
            'first_name' => 'Peter',
            'given_name' => 'Clever',
            'email' => 'mpc1@test.com',
            'username' => 'mpc1',
            'slug' => 'magezi',
            'password' => '123456',
            'remember_token' => Str::random(10)
        ]);
        $user = new User();
        $user->where('email', 'mpc1@test.com')->first()->roles()->detach($teacher);
        $user->where('email', 'mpc1@test.com')->first()->roles()->attach($teacher);

        $user->where('email', 'mpc1@test.com')->first()->subjects()->detach([$subject1->id, $subject2->id, $subject3->id]);
        $user->where('email', 'mpc1@test.com')->first()->subjects()->attach([$subject1->id, $subject2->id, $subject3->id]);
    }
}
