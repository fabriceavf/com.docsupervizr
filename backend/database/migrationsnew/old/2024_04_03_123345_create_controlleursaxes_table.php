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
        Schema::create('controlleursacces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pointeuse_id')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->unsignedBigInteger('deplacement_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('date_debut')->nullable();
            $table->string('date_fin')->nullable();
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
        Schema::dropIfExists('controlleursacces');
    }
};
