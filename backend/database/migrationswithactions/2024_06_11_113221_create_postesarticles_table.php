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
        Schema::create('createpostesarticles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postesarticle_id');

        });
        Schema::create('updatepostesarticles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postesarticle_id');

        });
        Schema::create('deletepostesarticles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postesarticle_id');

        });
        Schema::create('readpostesarticles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postesarticle_id');

        });
        Schema::create('postesarticles', function (Blueprint $table) {
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
        Schema::dropIfExists('postesarticles');
    }
};
