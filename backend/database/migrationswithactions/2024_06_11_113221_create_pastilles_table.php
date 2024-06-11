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
        Schema::create('createpastilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pastille_id');

        });
        Schema::create('updatepastilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pastille_id');

        });
        Schema::create('deletepastilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pastille_id');

        });
        Schema::create('readpastilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pastille_id');

        });
        Schema::create('pastilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
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
        Schema::dropIfExists('pastilles');
    }
};
