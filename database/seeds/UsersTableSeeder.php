<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            [
                'name' => 'super_admin',
                'username' => 'super_admin',
                'slug' => 'super_admin',
                'email' => 'super_admin@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null

            ],
            [
                'name' => 'admin',
                'username' => 'admin',
                'slug' => 'admin',
                'email' => 'admin@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null

            ]
            ,
            [
                'name' => 'headteacher',
                'username' => 'headteacher',
                'slug' => 'headteacher',
                'email' => 'headteacher@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null

            ],
            [
                'name' => 'academic',
                'username' => 'academic',
                'slug' => 'academic',
                'email' => 'academic@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null

            ],
            [
                'name' => 'teacher',
                'username' => 'teacher',
                'slug' => 'teacher',
                'email' => 'teacher@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null

            ],
            [
                'name' => 'secretary',
                'username' => 'secretary',
                'slug' => 'secretary',
                'email' => 'secretary@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null

            ],


        ]);

    }
}
