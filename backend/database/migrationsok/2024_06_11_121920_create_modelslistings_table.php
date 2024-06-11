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
        Schema::create('modelslistings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Libelle')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->text('postes')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->string('faction')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date_debut')->nullable();
            $table->integer('min_partage')->default(1);
            $table->longText('Generate')->nullable();
            $table->string('etats')->nullable();
            $table->unsignedBigInteger('user_id_2');
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->unsignedBigInteger('user_id_4')->nullable();
            $table->string('typelistings')->nullable();
            $table->text('horaires')->nullable();
            $table->string('directions')->nullable();
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
        Schema::dropIfExists('modelslistings');
    }
};
