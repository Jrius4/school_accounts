<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('paper_name')->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->string('paper_abbrev');
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');


        });
        Schema::create('paper_subject', function (Blueprint $table) {

            $table->unsignedBigInteger('paper_id');
            $table->unsignedBigInteger('subject_id');


            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('paper_id')->references('id')->on('papers')
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
        Schema::dropIfExists('subject_paper');
        Schema::dropIfExists('papers');

    }
}
