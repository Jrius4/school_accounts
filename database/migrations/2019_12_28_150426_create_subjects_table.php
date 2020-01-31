<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level')->nullable();
            $table->string('name')->unique();
            $table->string('subject_code')->unique()->nullable();
            $table->boolean('subject_compulsory')->nullable();
            $table->timestamps();
        });

        Schema::create('schclass_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('schclass_id');
            $table->unsignedBigInteger('subject_id');


            $table->foreign('schclass_id')->references('id')->on('schclasses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['schclass_id', 'subject_id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('schclass_subject');
    }
}
