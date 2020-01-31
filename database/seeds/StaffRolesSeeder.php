<?php

use App\Role;
use App\Schclass;
use App\Subject;
use App\User;
use Illuminate\Database\Seeder;

class StaffRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert_user = array(
            'name'=>'Okello Bosco',
            'username'=>'bosco',
            'slug'=>str_slug('bosco','-'),
            'password'=>bcrypt('123456'),
        );
        $insert_user2 = array(
            'name'=>'Kamya Tommy',
            'username'=>'tommy',
            'slug'=>str_slug('tommy','_'),
            'password'=>bcrypt('123456'),
        );
        $insert_user3 = array(
            'name'=>'Odeka Samuel',
            'username'=>'samuel',
            'slug'=>str_slug('samuel','_'),
            'password'=>bcrypt('123456'),
        );

        User::create($insert_user)->attachRole(Role::whereName('head_teacher')->first());
        User::create($insert_user2)->attachRole(Role::whereName('academic')->first());
        User::create($insert_user3)->attachRole(Role::whereName('teacher')->first());


        User::find(9)->schClasses()->detach(Schclass::find([1,3,5]));
        User::find(9)->schClasses()->attach(Schclass::find([1,3,5]));



        User::find(9)->subjects()->detach(Subject::find([1,4,7,9,16]));
        User::find(9)->subjects()->attach(Subject::find([1,4,7,9,16]));

        User::find(12)->schClasses()->detach(Schclass::find([2,4,5,6]));
        User::find(12)->schClasses()->attach(Schclass::find([2,4,5,6]));

        User::find(12)->subjects()->detach(Subject::find([2,3,4,17]));
        User::find(12)->subjects()->attach(Subject::find([2,3,4,17]));


    }
}
