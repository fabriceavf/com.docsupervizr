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
        Schema::create('createvilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ville_id');

        });
        Schema::create('updatevilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ville_id');

        });
        Schema::create('deletevilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ville_id');

        });
        Schema::create('readvilles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ville_id');

        });
        Schema::create('villes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->comment('is_select_label');
            $table->string('code')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('villes');
    }
};
