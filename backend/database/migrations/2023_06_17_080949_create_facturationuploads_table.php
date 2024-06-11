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
        Schema::dropIfExists('facturationuploads');
        Schema::create('facturationuploads', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('path');
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('facturationuploads');
    }
};
