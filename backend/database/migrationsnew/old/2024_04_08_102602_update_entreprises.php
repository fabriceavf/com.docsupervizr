<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::table('entreprises', function (Blueprint $table) {
            $table->string('db_host')->nullable();
            $table->string('db_user')->nullable();
            $table->string('db_pass')->nullable();
        });
     }catch (\Throwable $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn('db_host');
            $table->dropColumn('db_user');
            $table->dropColumn('db_pass');
        });
    }
};
