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
        Schema::create('etapes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('ordre')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->string('creat_by')->nullable();
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
        Schema::dropIfExists('etapes');
    }
};
