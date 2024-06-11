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
        Schema::create('creategraphiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('graphique_id');

        });
        Schema::create('updategraphiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('graphique_id');

        });
        Schema::create('deletegraphiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('graphique_id');

        });
        Schema::create('readgraphiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('graphique_id');

        });
        Schema::create('graphiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
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
        Schema::dropIfExists('graphiques');
    }
};
