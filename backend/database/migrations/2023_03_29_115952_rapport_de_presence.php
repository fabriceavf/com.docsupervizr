<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::dropIfExists('rapports');
        Schema::create('rapports', function (Blueprint $table) {

            $table->id();
            $table->string('mois')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('fonction_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('faction_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->text('day_01')->default(0)->nullable();
            $table->text('day_02')->default(0)->nullable();
            $table->text('day_03')->default(0)->nullable();
            $table->text('day_04')->default(0)->nullable();
            $table->text('day_05')->default(0)->nullable();
            $table->text('day_06')->default(0)->nullable();
            $table->text('day_07')->default(0)->nullable();
            $table->text('day_08')->default(0)->nullable();
            $table->text('day_09')->default(0)->nullable();
            $table->text('day_10')->default(0)->nullable();
            $table->text('day_11')->default(0)->nullable();
            $table->text('day_12')->default(0)->nullable();
            $table->text('day_13')->default(0)->nullable();
            $table->text('day_14')->default(0)->nullable();
            $table->text('day_15')->default(0)->nullable();
            $table->text('day_16')->default(0)->nullable();
            $table->text('day_17')->default(0)->nullable();
            $table->text('day_18')->default(0)->nullable();
            $table->text('day_19')->default(0)->nullable();
            $table->text('day_20')->default(0)->nullable();
            $table->text('day_21')->default(0)->nullable();
            $table->text('day_22')->default(0)->nullable();
            $table->text('day_23')->default(0)->nullable();
            $table->text('day_24')->default(0)->nullable();
            $table->text('day_25')->default(0)->nullable();
            $table->text('day_26')->default(0)->nullable();
            $table->text('day_27')->default(0)->nullable();
            $table->text('day_28')->default(0)->nullable();
            $table->text('day_29')->default(0)->nullable();
            $table->text('day_30')->default(0)->nullable();
            $table->text('day_31')->default(0)->nullable();
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
        Schema::dropIfExists('rapports');
    }
};
