<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatelistingsetatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{


        Schema::create('listingsetats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listingsjour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('present')->nullable()->default('non');
            $table->schemalessAttributes('extra_attributes')->nullable();
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
        Schema::dropIfExists('factions');
    }
}
