<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('client_zone', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('client_zone');
    }
}
