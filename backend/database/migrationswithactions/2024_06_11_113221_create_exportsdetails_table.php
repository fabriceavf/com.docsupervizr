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
        Schema::create('createexportsdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('exportsdetail_id');

        });
        Schema::create('updateexportsdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('exportsdetail_id');

        });
        Schema::create('deleteexportsdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('exportsdetail_id');

        });
        Schema::create('readexportsdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('exportsdetail_id');

        });
        Schema::create('exportsdetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('export_id')->nullable();
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
        Schema::dropIfExists('exportsdetails');
    }
};
