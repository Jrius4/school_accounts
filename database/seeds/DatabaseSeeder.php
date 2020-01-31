<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);

        $this->call(SchoolAccountTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
        $this->call(StudyLogicSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(TeacherSubjectSeederTable::class);
        $this->call(StudentInfoSeeder::class);

        $this->call(CityDemoSeeder::class);
        $this->call(StaffRolesSeeder::class);
        $this->call(BuildResultSeeder::class);
    }
}
