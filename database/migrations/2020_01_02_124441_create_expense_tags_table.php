<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('expense_tag_outflow', function (Blueprint $table) {
            $table->unsignedBigInteger('expense_tag_id');
            $table->unsignedBigInteger('outflow_id');

            $table->foreign('expense_tag_id')->references('id')->on('expense_tags')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('outflow_id')->references('id')->on('outflows')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['expense_tag_id', 'outflow_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_tags');
    }
}
