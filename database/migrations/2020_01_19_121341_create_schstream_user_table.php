<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchstreamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schstream_user', function (Blueprint $table) {
            $table->unsignedBigInteger('schstream_id');
            $table->unsignedBigInteger('user_id');




            $table->foreign('schstream_id')->references('id')->on('schstreams')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            // $table->primary(['schstream_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schstream_user', function (Blueprint $table) {
            //
        });
    }
}
