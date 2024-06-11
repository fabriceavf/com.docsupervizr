<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatelistingsjoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{


        Schema::create('listingsjours', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->timestamp('date')->nullable()->comment('types_datetime');
            $table->string('etats')->nullable();
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
