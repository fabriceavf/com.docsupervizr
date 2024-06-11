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
        Schema::create('createtypesheures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesheure_id');

        });
        Schema::create('updatetypesheures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesheure_id');

        });
        Schema::create('deletetypesheures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesheure_id');

        });
        Schema::create('readtypesheures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesheure_id');

        });
        Schema::create('typesheures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->text('libelle')->nullable();
            $table->text('description')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('typesheures');
    }
};
