<?php

use App\Role;
use App\Permission;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        // create roles
        $super_admin = new Role();
        $super_admin->name = "superadministrator";
        $super_admin->display_name = "Super Administrator";
        $super_admin->save();

        $admin = new Role();
        $admin->name = "administrator";
        $admin->display_name = "Administrator";
        $admin->save();

        $headteacher = new Role();
        $headteacher->name = "head_teacher";
        $headteacher->display_name = "Head Teacher";
        $headteacher->save();

        $academic = new Role();
        $academic->name = "academic";
        $academic->display_name = "Academic";
        $academic->save();

        $accountant = new Role();
        $accountant->name = "accountant";
        $accountant->display_name = "accountant";
        $accountant->save();

        $burser = new Role();
        $burser->name = "burser";
        $burser->display_name = "burser";
        $burser->save();

        $teacher = new Role();
        $teacher->name = "teacher";
        $teacher->display_name = "Teacher";
        $teacher->save();

        $secretary = new Role();
        $secretary->name = "secretary";
        $secretary->display_name = "Secretary";
        $secretary->save();



        // Attach roles

        $user = new User();

        // first user as super_admin
        $user1 = User::find(1);
        $user1->detachRole($super_admin);
        $user1->attachRole($super_admin);

        // no2 user as super_admin
        $user2 = User::find(2);
        $user2->detachRole($admin);
        $user2->attachRole($admin);

         // second user as headteacher
         $user3 = User::find(3);
         $user3->detachRole($headteacher);
         $user3->attachRole($headteacher);

        // second user as editor
        $user4 = User::find(4);
        $user4->detachRole($academic);
        $user4->attachRole($academic);

        // third user as author
        $user5 = User::find(5);
        $user5->detachRole($teacher);
        $user5->attachRole($teacher);

        // forth user as contributor
        $user6 = User::find(6);
        $user6->detachRole($secretary);
        $user6->attachRole($secretary);


        User::create([
            'name'=>'Umar Boss',
            'username'=>'Umar',
            'slug'=>'umar',
            'password'=>'123456',
            'remember_token'=>Str::random(10)
            ]);

        $user->whereName('Umar Boss')->first()->roles()->detach($headteacher);
        $user->whereName('Umar Boss')->first()->roles()->attach($headteacher);

        $user->create(array(
            'name'=>'Burser',
            'username'=>'burser',
            'slug'=>'burser',
            'password'=>'123456',
            'remember_token'=>Str::random(10)
        ));
        $user->whereName('Burser')->first()->roles()->detach($burser);
        $user->whereName('Burser')->first()->roles()->attach($burser);

        $user90 = User::create([
                'name'=>'accountant',
                'username'=>'accountant',
                'slug'=>'accountant',
                'password'=>'123456',
                'remember_token'=>Str::random(10)
                ])->attachRole($accountant);


    }
}