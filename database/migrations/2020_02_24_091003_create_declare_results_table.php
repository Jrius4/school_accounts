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
            $table->string('set_id')->nullable();
            $table->string('student_id')->nullable();
            $table->string('schclass_id')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('declare_results');
    }
}
