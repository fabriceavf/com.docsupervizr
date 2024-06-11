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
        Schema::create('createidentifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identification_id');

        });
        Schema::create('updateidentifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identification_id');

        });
        Schema::create('deleteidentifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identification_id');

        });
        Schema::create('readidentifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identification_id');

        });
        Schema::create('identifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('carte_id')->nullable();
            $table->string('date_debut')->nullable();
            $table->string('date_fin')->nullable();
            $table->string('statuts')->nullable();
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
        Schema::dropIfExists('identifications');
    }
};
