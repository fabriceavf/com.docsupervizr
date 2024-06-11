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
        Schema::create('createfonctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fonction_id');

        });
        Schema::create('updatefonctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fonction_id');

        });
        Schema::create('deletefonctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fonction_id');

        });
        Schema::create('readfonctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fonction_id');

        });
        Schema::create('fonctions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('libelle')->comment('is_select_label');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('service_id')->nullable();
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
        Schema::dropIfExists('fonctions');
    }
};
