<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_name')->unique()->nullable();
            $table->string('account_slug')->unique()->nullable();
            $table->string('amount',9,2)->default(0);
            $table->string('to_pay')->nullable();
            $table->string('set_minium_balance')->nullable();
            // $table->
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
        Schema::dropIfExists('school_accounts');
    }
}
