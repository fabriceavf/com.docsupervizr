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
        Schema::table('userszones', function (Blueprint $table) {
            $table->renameColumn('users_id', 'user_id');
            $table->schemalessAttributes('extra_attributes')->nullable();
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
        Schema::table('userszones', function (Blueprint $table) {
            $table->renameColumn('user_id', 'users_id');
            $table->dropColumn('extra_attributes');
        });
    }
};
