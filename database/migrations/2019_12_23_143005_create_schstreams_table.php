<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchstreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schstreams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();

        });

        // Schema::create('schclass_schstream', function (Blueprint $table) {
        //     $table->unsignedBigInteger('schclass_id');
        //     $table->unsignedBigInteger('schstream_id');

        //     $table->foreign('schclass_id')->references('id')->on('schclasses')
        //         ->onUpdate('cascade')->onDelete('cascade');

        //     $table->foreign('schstream_id')->references('id')->on('schstreams')
        //         ->onUpdate('cascade')->onDelete('cascade');

        //     $table->primary(['schclass_id', 'schstream_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schstreams');
        // Schema::dropIfExists('schclass_schstream');
    }
}
