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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('generation')->nullable();
            $table->string('serie')->nullable();
            $table->string('valeur')->nullable();
            $table->string('moteur')->nullable();
            $table->string('poids')->nullable();
            $table->string('creat_by')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('vehicules');
    }
};
