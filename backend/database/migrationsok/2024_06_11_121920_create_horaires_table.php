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
        Schema::create('horaires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->comment('is_select_label');
            $table->time('debut');
            $table->time('fin');
            $table->string('tolerance')->nullable()->default('0');
            $table->string('type')->default('jour');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->string('parent')->nullable();
            $table->string('parentId')->nullable();
            $table->string('vol_horaire_min')->nullable();
            $table->string('nmb_pointage_min')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
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
        Schema::dropIfExists('horaires');
    }
};
