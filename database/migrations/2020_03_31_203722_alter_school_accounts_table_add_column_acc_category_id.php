<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSchoolAccountsTableAddColumnAccCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('acc_category_id')->nullable();
            $table->foreign('acc_category_id')->references('id')->on('acc_categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_accounts', function (Blueprint $table) {
            $table->dropColumn('acc_category_id');
        });
    }
}
