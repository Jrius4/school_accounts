<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('structure_name')->nullable();
            $table->unsignedDecimal('amount',9,2)->default(0);
            $table->unsignedBigInteger('school_account_id')->nullable();
            $table->timestamps();

            $table->foreign('school_account_id')->references('id')->on('school_accounts')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_structures');
    }
}
