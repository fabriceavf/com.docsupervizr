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
        Schema::create('createtrackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_id');

        });
        Schema::create('updatetrackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_id');

        });
        Schema::create('deletetrackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_id');

        });
        Schema::create('readtrackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_id');

        });
        Schema::create('trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('balise_id')->nullable();
            $table->unsignedBigInteger('moyenstransport_id')->nullable();
            $table->string('date_debut')->nullable();
            $table->string('date_fin')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackings');
    }
};
