<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{

        Schema::create('joursferies',function(Blueprint $table){
            $table->id();
            $table->text('raison')->nullable();
            $table->dateTime('debut')->nullable()->comment('types_datetime');
            $table->dateTime('fin')->nullable()->comment('types_datetime');
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
        Schema::dropIfExists('calendriers');
        Schema::dropIfExists('joursferies');
    }
};
