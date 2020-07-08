<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       if(Schema::connection('mysql2')->hasTable('blogs')) \DB::connection('mysql2')->statement("DROP TABLE blogs");
        Schema::connection('mysql2')->create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->string('name');
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
        Schema::connection('mysql2')->dropIfExists('blogs');
    }
}
