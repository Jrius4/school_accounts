<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schclass_id');
            $table->unsignedBigInteger('fees_amount');
            $table->timestamps();
            $table->foreign('schclass_id')->references('id')->on('schclasses')
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
        Schema::dropIfExists('class_fees');
    }
}
