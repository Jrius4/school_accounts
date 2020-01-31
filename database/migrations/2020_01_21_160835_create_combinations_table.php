<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level');
            $table->string('first_subject');
            $table->string('second_subject');
            $table->string('third_subject');
            $table->string('subsidiary');
            $table->string('combination_name')->unique();
            $table->timestamps();
        });

        // Schema::create('combination_student', function (Blueprint $table) {
        //     $table->unsignedBigInteger('combination_id');
        //     $table->unsignedBigInteger('student_id');

        //     $table->foreign('combination_id')->references('id')->on('combinations')
        //         ->onUpdate('cascade')->onDelete('cascade');
        //     $table->foreign('student_id')->references('id')->on('students')
        //     ->onUpdate('cascade')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('combination_student');
        Schema::dropIfExists('combinations');
    }
}
