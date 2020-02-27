<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('roll_number')->unique();
            $table->string('password');
            $table->unsignedBigInteger('schclass_id')->nullable();
            $table->unsignedBigInteger('schstream_id')->nullable();
            $table->unsignedBigInteger('combination_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('school_presence_status')->nullable()->default('active');
            $table->string('amount_paid')->nullable();
            $table->string('image')->nullable();
            $table->string('medical_form')->nullable();
            $table->string('admission_form')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('schclass_id')->references('id')->on('schclasses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('schstream_id')->references('id')->on('schstreams')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('combination_id')->references('id')->on('combinations')
                ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('classes');
        // Schema::dropIfExists('streams');
        // Schema::dropIfExists('combinations');
        // Schema::dropIfExists('subjects');
        Schema::dropIfExists('students');
        // Schema::dropIfExists('subjects_students');
    }
}
