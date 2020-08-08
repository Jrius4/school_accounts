<?php

use Carbon\Carbon;
use Faker\Factory;
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
        $faker = Factory::create();

        DB::table('users')->insert([
            [
                'last_name' => 'super_admin',
                'username' => 'super_admin',
                'slug' => 'super_admin',
                'email' => 'super_admin@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null,
                'entry_date' => Carbon::now()->modify('-'.rand(3,6).' years'),
                'image' => 'user_all.png',
                'biography'=>$faker->paragraph(5,3)

            ],
            [
                'last_name' => 'admin',
                'username' => 'admin',
                'slug' => 'admin',
                'email' => 'admin@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null,
                'entry_date' => Carbon::now()->modify('-'.rand(3,6).' years'),
                'image' => 'user_all.png',
                'biography'=>$faker->paragraph(5,3)

            ]
            ,
            [
                'last_name' => 'headteacher',
                'username' => 'headteacher',
                'slug' => 'headteacher',
                'email' => 'headteacher@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null,
                'entry_date' => Carbon::now()->modify('-'.rand(3,6).' years'),
                'image' => 'user_all.png',
                'biography'=>$faker->paragraph(5,3)

            ],
            [
                'last_name' => 'academic',
                'username' => 'academic',
                'slug' => 'academic',
                'email' => 'academic@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null,
                'entry_date' => Carbon::now()->modify('-'.rand(3,6).' years'),
                'image' => 'user_all.png',
                'biography'=>$faker->paragraph(5,3)

            ],
            [
                'last_name' => 'teacher',
                'username' => 'teacher',
                'slug' => 'teacher',
                'email' => 'teacher@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null,
                'entry_date' => Carbon::now()->modify('-'.rand(3,6).' years'),
                'image' => 'user_all.png',
                'biography'=>$faker->paragraph(5,3)

            ],
            [
                'last_name' => 'secretary',
                'username' => 'secretary',
                'slug' => 'secretary',
                'email' => 'secretary@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'remember_token' => null,
                'entry_date' => Carbon::now()->modify('-'.rand(3,6).' years'),
                'image' => 'user_all.png',
                'biography'=>$faker->paragraph(5,3)

            ],


        ]);

    }
}
