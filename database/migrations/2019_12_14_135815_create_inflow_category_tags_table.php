<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInflowCategoryTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inflow_category_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('inflow_category_tag', function (Blueprint $table) {
            $table->bigInteger('category_id');
            $table->bigInteger('category_tag_id');
            $table->primary(['category_id', 'category_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inflow_category_tags');
        Schema::dropIfExists('inflow_category_tag');
    }
}
