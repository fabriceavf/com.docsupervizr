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
        Schema::create('createentreprises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entreprise_id');

        });
        Schema::create('updateentreprises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entreprise_id');

        });
        Schema::create('deleteentreprises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entreprise_id');

        });
        Schema::create('readentreprises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entreprise_id');

        });
        Schema::create('entreprises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom')->nullable();
            $table->string('menu')->nullable();
            $table->string('host')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->text('icon')->nullable();
            $table->text('favicon')->nullable();
            $table->string('status')->nullable();
            $table->string('db_host')->nullable();
            $table->string('db_user')->nullable();
            $table->string('db_pas')->nullable();
            $table->string('badge_avant')->nullable();
            $table->string('badge_arriere')->nullable();
            $table->string('modules')->nullable();
            $table->string('filemodules')->nullable();
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
        Schema::dropIfExists('entreprises');
    }
};
