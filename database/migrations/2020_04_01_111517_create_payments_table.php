<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reciept_no')->nullable();
            $table->string('paymentType')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->longText('paidItems')->nullable();
            $table->string('fullAmount')->nullable();
            $table->string('balance')->nullable();
            $table->string('paid_by')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
