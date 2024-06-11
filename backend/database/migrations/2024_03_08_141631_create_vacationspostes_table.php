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
        Schema::create('vacationspostes', function (Blueprint $table) {
            $table->id();
            $table->string('total')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->schemalessAttributes('extra_attributes')->nullable();
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
        Schema::dropIfExists('vacationspostes');
    }
};
