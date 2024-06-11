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
        Schema::create('createetapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etape_id');

        });
        Schema::create('updateetapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etape_id');

        });
        Schema::create('deleteetapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etape_id');

        });
        Schema::create('readetapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('etape_id');

        });
        Schema::create('etapes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->string('ordre')->nullable();
            $table->unsignedBigInteger('ligne_id')->nullable();
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
        Schema::dropIfExists('etapes');
    }
};
