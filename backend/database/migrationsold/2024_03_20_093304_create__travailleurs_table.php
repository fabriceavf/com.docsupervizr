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
        Schema::create('travailleurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('horaire_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('lun')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('mer')->default(0);
            $table->integer('jeu')->default(0);
            $table->integer('ven')->default(0);
            $table->integer('sam')->default(0);
            $table->integer('dim')->default(0);
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
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
        Schema::dropIfExists('travailleurs');
    }
};
