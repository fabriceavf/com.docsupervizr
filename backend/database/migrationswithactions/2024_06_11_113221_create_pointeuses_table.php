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
        Schema::create('createpointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointeuse_id');

        });
        Schema::create('updatepointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointeuse_id');

        });
        Schema::create('deletepointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointeuse_id');

        });
        Schema::create('readpointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointeuse_id');

        });
        Schema::create('pointeuses', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('code')->nullable();
            $table->string('libelle')->comment('is_select_label');
            $table->timestamps();
            $table->string('nom_local')->nullable();
            $table->unsignedBigInteger('supervirzclient_id')->nullable();
            $table->string('code_teleric')->nullable();
            $table->longText('postes')->nullable();
            $table->longText('Taches')->nullable();
            $table->text('lun')->nullable()->default('0');
            $table->text('mar')->nullable()->default('0');
            $table->text('mer')->nullable()->default('0');
            $table->text('jeu')->nullable()->default('0');
            $table->text('ven')->nullable()->default('0');
            $table->text('sam')->nullable()->default('0');
            $table->text('dim')->nullable()->default('0');
            $table->unsignedBigInteger('site_id')->nullable();
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
        Schema::dropIfExists('pointeuses');
    }
};
