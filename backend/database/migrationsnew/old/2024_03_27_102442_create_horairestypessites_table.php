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
        Schema::create('horairestypessites', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->comment('is_select_label')->nullable();
            $table->time('debut')->nullable();
            $table->time('fin')->nullable();
            $table->unsignedBigInteger('typessite_id')->nullable();
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
        Schema::dropIfExists('horairestypessites');
    }
};
