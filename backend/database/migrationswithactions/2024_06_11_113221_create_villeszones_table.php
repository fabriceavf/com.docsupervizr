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
        Schema::create('createvilleszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('villeszone_id');

        });
        Schema::create('updatevilleszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('villeszone_id');

        });
        Schema::create('deletevilleszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('villeszone_id');

        });
        Schema::create('readvilleszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('villeszone_id');

        });
        Schema::create('villeszones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ville_id')->nullable();
            $table->string('zone_id')->nullable();
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
        Schema::dropIfExists('villeszones');
    }
};
