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
        Schema::create('analysespointeuses',function(Blueprint $table){
            $table->id();
            $table->string('pointeuses')->nullable();
            $table->string('semaine')->nullable();
            $table->string('lun')->default(0)->nullable();
            $table->string('mar')->default(0)->nullable();
            $table->string('mer')->default(0)->nullable();
            $table->string('jeu')->default(0)->nullable();
            $table->string('ven')->default(0)->nullable();
            $table->string('sam')->default(0)->nullable();
            $table->string('dim')->default(0)->nullable();
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
        Schema::dropIfExists('analysespointeuses');

    }
};
