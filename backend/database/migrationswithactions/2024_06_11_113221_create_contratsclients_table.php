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
        Schema::create('createcontratsclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contratsclient_id');

        });
        Schema::create('updatecontratsclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contratsclient_id');

        });
        Schema::create('deletecontratsclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contratsclient_id');

        });
        Schema::create('readcontratsclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contratsclient_id');

        });
        Schema::create('contratsclients', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->longText('AllSites')->nullable();
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
        Schema::dropIfExists('contratsclients');
    }
};
