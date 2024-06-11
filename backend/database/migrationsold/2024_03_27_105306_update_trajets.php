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
        Schema::table('trajets', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('durees')->nullable();
            $table->dropColumn('depart');
            $table->dropColumn('arrive');
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
        Schema::table('trajets', function (Blueprint $table) {
            $table->string('depart')->nullable();
            $table->string('arrive')->nullable();
            $table->dropColumn('site_id');
            $table->dropColumn('durees');
        });
    }
};
