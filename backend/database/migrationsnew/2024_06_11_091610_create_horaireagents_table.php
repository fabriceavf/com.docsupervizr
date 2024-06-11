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
        Schema::create('horaireagents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('horaire_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('lun')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('mer')->default(0);
            $table->integer('jeu')->default(0);
            $table->integer('ven')->default(0);
            $table->integer('sam')->default(0);
            $table->integer('dim')->default(0);
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->string('typesagents')->nullable();
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
        Schema::dropIfExists('horaireagents');
    }
};
