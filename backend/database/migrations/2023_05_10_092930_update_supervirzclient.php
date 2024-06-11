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
        Schema::table('supervirzclients', function (Blueprint $table) {
            $table->string('db_connection')->nullable();
            $table->string('db_host')->nullable();
            $table->string('db_port')->nullable();
            $table->string('db_database')->nullable();
            $table->string('db_username')->nullable();
            $table->string('db_password')->nullable();
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
        Schema::table('supervirzclients', function (Blueprint $table) {
            $table->dropColumn('db_connection');
            $table->dropColumn('db_host');
            $table->dropColumn('db_port');
            $table->dropColumn('db_database');
            $table->dropColumn('db_username');
            $table->dropColumn('db_password');
        });
    }
};
