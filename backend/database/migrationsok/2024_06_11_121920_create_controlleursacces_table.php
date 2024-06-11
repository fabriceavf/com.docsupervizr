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
        Schema::create('controlleursacces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pointeuse_id')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->unsignedBigInteger('deplacement_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('date_debut')->nullable();
            $table->string('date_fin')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('type');
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
        Schema::dropIfExists('controlleursacces');
    }
};
