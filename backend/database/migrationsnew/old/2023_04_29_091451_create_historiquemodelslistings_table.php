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
        Schema::create('historiquemodelslistings', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable()->comment('is_select_label');
            $table->text('ancien')->nullable();
            $table->text('nouveau')->nullable();
            $table->unsignedBigInteger('modelisting_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('historiquemodelslistings');
    }
};
