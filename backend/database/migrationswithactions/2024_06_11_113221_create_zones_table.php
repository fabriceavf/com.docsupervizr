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
        Schema::create('createzones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone_id');

        });
        Schema::create('updatezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone_id');

        });
        Schema::create('deletezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone_id');

        });
        Schema::create('readzones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zone_id');

        });
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('code')->nullable();
            $table->string('libelle')->comment('is_select_label');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->timestamps();
            $table->integer('total_titulaires_therorique')->default(0);
            $table->integer('total_titulaires_reel_jour')->default(0);
            $table->integer('total_titulaires_reel_nuit')->default(0);
            $table->integer('total_present_jour')->default(0);
            $table->integer('total_present_nuit')->default(0);
            $table->integer('ordre')->nullable();
            $table->string('ville_id')->nullable();
            $table->json('extra_attributes')->nullable();
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
        Schema::dropIfExists('zones');
    }
};
