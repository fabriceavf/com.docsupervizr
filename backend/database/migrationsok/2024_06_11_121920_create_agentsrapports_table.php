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
        Schema::create('agentsrapports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mois')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('jour_abscences')->default('0');
            $table->string('jour_presences')->default('0');
            $table->text('day_01')->nullable()->default('0');
            $table->text('day_02')->nullable()->default('0');
            $table->text('day_03')->nullable()->default('0');
            $table->text('day_04')->nullable()->default('0');
            $table->text('day_05')->nullable()->default('0');
            $table->text('day_06')->nullable()->default('0');
            $table->text('day_07')->nullable()->default('0');
            $table->text('day_08')->nullable()->default('0');
            $table->text('day_09')->nullable()->default('0');
            $table->text('day_10')->nullable()->default('0');
            $table->text('day_11')->nullable()->default('0');
            $table->text('day_12')->nullable()->default('0');
            $table->text('day_13')->nullable()->default('0');
            $table->text('day_14')->nullable()->default('0');
            $table->text('day_15')->nullable()->default('0');
            $table->text('day_16')->nullable()->default('0');
            $table->text('day_17')->nullable()->default('0');
            $table->text('day_18')->nullable()->default('0');
            $table->text('day_19')->nullable()->default('0');
            $table->text('day_20')->nullable()->default('0');
            $table->text('day_21')->nullable()->default('0');
            $table->text('day_22')->nullable()->default('0');
            $table->text('day_23')->nullable()->default('0');
            $table->text('day_24')->nullable()->default('0');
            $table->text('day_25')->nullable()->default('0');
            $table->text('day_26')->nullable()->default('0');
            $table->text('day_27')->nullable()->default('0');
            $table->text('day_28')->nullable()->default('0');
            $table->text('day_29')->nullable()->default('0');
            $table->text('day_30')->nullable()->default('0');
            $table->text('day_31')->nullable()->default('0');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
            $table->string('creat_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agentsrapports');
    }
};
