<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointeusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('pointeuses', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('code')->nullable();
            $table->string('libelle')->comment('is_select_label');
            $table->unsignedBigInteger('recupere_id')->nullable();
            $table->timestamps();
        });
        Schema::create('recuperes', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->comment('is_select_label');
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
        Schema::dropIfExists('pointeuses');
        Schema::dropIfExists('recuperes');
    }
}
