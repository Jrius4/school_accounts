<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchclassUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schclass_user', function (Blueprint $table) {
            $table->unsignedBigInteger('schclass_id');
            $table->unsignedBigInteger('user_id');




            $table->foreign('schclass_id')->references('id')->on('schclasses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            // $table->primary(['schclass_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schclass_user', function (Blueprint $table) {
            //
        });
    }
}
