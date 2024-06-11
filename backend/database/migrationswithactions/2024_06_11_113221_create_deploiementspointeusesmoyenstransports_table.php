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
        Schema::create('createdeploiementspointeusesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deploiementspointeusesmoyenstransport_id');

        });
        Schema::create('updatedeploiementspointeusesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deploiementspointeusesmoyenstransport_id');

        });
        Schema::create('deletedeploiementspointeusesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deploiementspointeusesmoyenstransport_id');

        });
        Schema::create('readdeploiementspointeusesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deploiementspointeusesmoyenstransport_id');

        });
        Schema::create('deploiementspointeusesmoyenstransports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->string('pointeuse_id')->nullable();
            $table->string('moyenstransport_id')->nullable();
            $table->string('debut')->nullable();
            $table->string('fin')->nullable();
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
        Schema::dropIfExists('deploiementspointeusesmoyenstransports');
    }
};
