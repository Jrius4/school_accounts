<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        // crud student
        $crudStudent = new Permission();
        $crudStudent->name = "crud-student";
        $crudStudent->save();

        // cru student
        $cruStudent = new Permission();
        $cruStudent->name = "cru-student";
        $cruStudent->save();


        // crud teacher
        $crudTeacher = new Permission();
        $crudTeacher->name = "crud-teacher";
        $crudTeacher->save();

        // crud results
        $crudResults = new Permission();
        $crudResults->name = "crud-result";
        $crudResults->save();

        // crud user
        $crudUser = new Permission();
        $crudUser->name = "crud-user";
        $crudUser->save();






        // attach roles permissions
        $superadmin = Role::whereName('superadministrator')->first();
        $admin = Role::whereName('administrator')->first();
        $head_teacher = Role::whereName('head_teacher')->first();
        $academic = Role::whereName('academic')->first();
        $teacher = Role::whereName('teacher')->first();
        $secretary = Role::whereName('secretary')->first();

        $superadmin->detachPermissions([$crudResults, $crudTeacher, $crudStudent, $crudUser]);
        $superadmin->attachPermissions([$crudResults, $crudTeacher, $crudStudent, $crudUser]);

        $admin->detachPermissions([$crudResults, $crudTeacher, $crudStudent, $crudUser]);
        $admin->attachPermissions([$crudResults, $crudTeacher, $crudStudent, $crudUser]);

        $head_teacher->detachPermissions([$crudResults, $crudTeacher, $crudStudent, $crudUser]);
        $head_teacher->attachPermissions([$crudResults, $crudTeacher, $crudStudent, $crudUser]);

        $academic->detachPermissions([$crudResults, $crudTeacher, $crudStudent]);
        $academic->attachPermissions([$crudResults, $crudTeacher, $crudStudent]);

        $teacher->detachPermissions([$crudResults]);
        $teacher->attachPermissions([$crudResults]);

        $secretary->detachPermissions([$cruStudent]);
        $secretary->attachPermissions([$cruStudent]);





    }
}
