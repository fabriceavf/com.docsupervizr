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
        Schema::create('supervirzclientshides', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->unsignedBigInteger('supervirzclient_id')->nullable();
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
        Schema::dropIfExists('supervirzclientshides');
    }
};
