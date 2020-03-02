<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs',function(Blueprint $table){
            $table->smallIncrements('id');
            $table->string('name')->unique()->default('administrator');
            $table->string('slug')->default('administrator');
            $table->timestamps();

        });
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('is_class_teacher')->nullable();
            $table->string('slug')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('former_school')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('join_as')->nullable();
            $table->string('some_form')->nullable();
            $table->text('biography')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
        Schema::dropIfExists('users');
    }
}
