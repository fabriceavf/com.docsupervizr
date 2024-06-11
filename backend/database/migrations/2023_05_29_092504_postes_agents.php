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
        Schema::dropIfExists('postesagents');
        Schema::create('postesagents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('faction')->nullable();
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
        Schema::dropIfExists('postesagents');
    }
};
