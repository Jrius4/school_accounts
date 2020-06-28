<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('token')->nullable();
            $table->string('expensetype')->nullable();
            $table->text('expenseItems')->nullable();
            $table->text('expenseInfo')->nullable();
            $table->text('expenseTerm')->nullable();
            $table->string('expenseTotal')->nullable();
            $table->text('makeBorrowItems')->nullable();
            $table->text('makeLoanBorrowItems')->nullable();
            $table->string('salaryPaymentType')->nullable();
            $table->string('salaryTerm')->nullable();
            $table->string('totalBorrow')->nullable();
            $table->string('totalBorrowLoan')->nullable();
            $table->text('worker')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('expenses');
    }
}
