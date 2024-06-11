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
        Schema::create('createterminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('terminal_id');

        });
        Schema::create('updateterminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('terminal_id');

        });
        Schema::create('deleteterminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('terminal_id');

        });
        Schema::create('readterminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('terminal_id');

        });
        Schema::create('terminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->comment('is_select_label');
            $table->string('adresse_mac');
            $table->string('etat');
            $table->string('alimentation');
            $table->string('reseau');
            $table->unsignedBigInteger('voiture_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
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
        Schema::dropIfExists('terminals');
    }
};
