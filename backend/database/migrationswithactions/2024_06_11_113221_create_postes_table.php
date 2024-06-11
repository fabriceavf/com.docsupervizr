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
        Schema::create('createpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('poste_id');

        });
        Schema::create('updatepostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('poste_id');

        });
        Schema::create('deletepostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('poste_id');

        });
        Schema::create('readpostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('poste_id');

        });
        Schema::create('postes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('code')->nullable();
            $table->string('libelle')->comment('is_select_label');
            $table->text('nature')->nullable();
            $table->text('coordonnees')->nullable();
            $table->unsignedBigInteger('site_id')->nullable()->index('postes_site_id_foreign');
            $table->timestamps();
            $table->string('jours')->nullable();
            $table->unsignedBigInteger('contratsclient_id')->nullable()->index('postes_contratsclient_id_foreign');
            $table->integer('maxjours')->default(0);
            $table->integer('maxnuits')->default(0);
            $table->longText('NbrsJours')->nullable();
            $table->longText('NbrsNuits')->nullable();
            $table->longText('IsCouvert')->nullable();
            $table->longText('pointeuses')->nullable();
            $table->longText('Agentjour')->nullable();
            $table->longText('Agentnuit')->nullable();
            $table->longText('couvertAgentjour')->nullable();
            $table->longText('couvertAgentnuit')->nullable();
            $table->string('type')->nullable();
            $table->string('typeagents')->nullable();
            $table->unsignedBigInteger('typesposte_id')->nullable();
            $table->unsignedBigInteger('postesarticle_id')->nullable();
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
        Schema::dropIfExists('postes');
    }
};
