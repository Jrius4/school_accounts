<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('indexno')->nullable();
            $table->string('student_name')->nullable();
            $table->string('subject_name')->nullable();
            $table->unsignedBigInteger('schclass_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->longText('papers')->nullable();
            $table->longText('b_o_t')->nullable();
            $table->longText('m_o_t')->nullable();
            $table->longText('e_o_t')->nullable();
            $table->string('total')->nullable();
            $table->string('grade')->nullable();
            $table->string('point')->nullable();
            $table->longText('overall')->nullable();
            $table->longText('comment')->nullable();
            $table->unsignedBigInteger('set_id')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
