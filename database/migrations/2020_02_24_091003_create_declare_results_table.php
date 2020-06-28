<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeclareResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declare_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('year');
            $table->string('term_id')->nullable();
            $table->string('exmset_id')->nullable();
            $table->string('student_id')->nullable();
            $table->string('schclass_id')->nullable();
            $table->string('status');
            $table->string('message')->nullable();
            $table->timestamps();

            // $table->foreign('term_id')->references('id')->on('terms')
            //     ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('exmset_id')->references('id')->on('exmsets')
            //     ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('student_id')->references('id')->on('students')
            //     ->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('schclass_id')->references('id')->on('students')
            //     ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declare_results');
    }
}
