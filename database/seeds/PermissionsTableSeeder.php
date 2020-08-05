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
        $crudStudent->name = "crud_student";
        $crudStudent->save();

        // cru student
        $cruStudent = new Permission();
        $cruStudent->name = "cru_student";
        $cruStudent->save();


        // crud teacher
        $crudTeacher = new Permission();
        $crudTeacher->name = "crud_teacher";
        $crudTeacher->save();

        // crud results
        $crudResults = new Permission();
        $crudResults->name = "crud_result";
        $crudResults->save();

        // crud user
        $crudUser = new Permission();
        $crudUser->name = "crud_user";
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

        
        $create_staff = Permission::create([
            'name'=>'create_staff',
            'display_name'=>'create staff',
            'description'=>'allowed to add new staff',
        ]);
        $edit_staff = Permission::create([
            'name'=>'edit_staff',
            'display_name'=>'edit staff',
            'description'=>'allowed to edit staff',
        ]);
        $view_staffs = Permission::create([
            'name'=>'view_staffs',
            'display_name'=>'view staffs',
            'description'=>'allowed to view staffs',
        ]);
        $delete_staffs = Permission::create([
            'name'=>'delete_staffs',
            'display_name'=>'delete staffs',
            'description'=>'allowed to delete staffs',
        ]);


        $create_salaries = Permission::create([
            'name'=>'create_salaries',
            'display_name'=>'create salaries',
            'description'=>'allowed to add new salaries',
        ]);
        $edit_salaries = Permission::create([
            'name'=>'edit_salaries',
            'display_name'=>'edit salaries',
            'description'=>'allowed to edit salaries',
        ]);
        $view_salaries = Permission::create([
            'name'=>'view_salaries',
            'display_name'=>'view salaries',
            'description'=>'allowed to view salaries',
        ]);
        $delete_salaries = Permission::create([
            'name'=>'delete_salaries',
            'display_name'=>'delete salaries',
            'description'=>'allowed to delete salaries',
        ]);

        $create_student = Permission::create([
            'name'=>'create_student',
            'display_name'=>'create student',
            'description'=>'allowed to add new student',
        ]);
        $edit_student = Permission::create([
            'name'=>'edit_student',
            'display_name'=>'edit student',
            'description'=>'allowed to edit student',
        ]);
        $view_students = Permission::create([
            'name'=>'view_students',
            'display_name'=>'view students',
            'description'=>'allowed to view students',
        ]);
        $delete_students = Permission::create([
            'name'=>'delete_students',
            'display_name'=>'delete students',
            'description'=>'allowed to delete students',
        ]);

        $academic->detachPermissions([$view_staffs,
        $delete_staffs,
        $create_student,$edit_student,
        $view_students,$delete_students]);
        $academic->attachPermissions([$view_staffs,
        $delete_staffs,
        $create_student,$edit_student,
        $view_students,$delete_students]);


        $academic->detachPermissions([$view_staffs,
        $delete_staffs,
        $create_student,$edit_student,
        $view_students,$delete_students]);
        $academic->attachPermissions([$view_staffs,
        $delete_staffs,
        $create_student,$edit_student,
        $view_students,$delete_students]);

        $head_teacher->detachPermissions([
        $create_staff,$edit_staff,
        $view_staffs,$delete_staffs,
        $create_student,$edit_student,
        $view_students,$delete_students,
        $create_salaries,$edit_salaries,
        $view_salaries,$delete_salaries]);
        $head_teacher->attachPermissions([$create_staff,$edit_staff,
        $view_staffs,$delete_staffs,
        $create_student,$edit_student,
        $view_students,$delete_students,
        $create_salaries,$edit_salaries,
        $view_salaries,$delete_salaries]);
    }
}
