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
        Schema::create('staffs', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name')->unique()->default('administrator');
            $table->string('slug')->default('administrator');
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('given_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('username')->unique();
            $table->string('is_class_teacher')->nullable();
            $table->string('slug')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('wage_salary')->default('0');
            $table->string('wage_paid')->default('0');
            $table->string('wage_balance')->default('0');
            $table->string('wage_loan')->default('0');
            $table->string('wage_upfront')->default('0');
            $table->string('image')->nullable();
            $table->string('former_school')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('join_as')->nullable();
            $table->string('some_form')->nullable();
            $table->text('biography')->nullable();
            $table->text('api_token')->nullable();
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
