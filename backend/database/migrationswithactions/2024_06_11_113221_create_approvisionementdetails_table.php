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
        Schema::create('createapprovisionementdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approvisionementdetail_id');

        });
        Schema::create('updateapprovisionementdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approvisionementdetail_id');

        });
        Schema::create('deleteapprovisionementdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approvisionementdetail_id');

        });
        Schema::create('readapprovisionementdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('approvisionementdetail_id');

        });
        Schema::create('approvisionementdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('approvisionement_id')->nullable();
            $table->integer('quantite')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('approvisionementdetails');
    }
};
