<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('outflow_category_id')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->string('made_by');
            $table->longText('description');
            $table->longText('message')->nullable();
            $table->string('total')->default(0);
            $table->timestamps();

            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('outflow_category_id')->references('id')->on('outflow_categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outflows');
    }
}
