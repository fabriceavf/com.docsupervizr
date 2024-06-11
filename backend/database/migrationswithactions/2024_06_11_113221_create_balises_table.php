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
        Schema::create('createbalises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('balise_id');

        });
        Schema::create('updatebalises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('balise_id');

        });
        Schema::create('deletebalises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('balise_id');

        });
        Schema::create('readbalises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('balise_id');

        });
        Schema::create('balises', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('imei', 50);
            $table->timestamps();
            $table->string('libelle')->nullable();
            $table->string('ref')->nullable();
            $table->json('extra_attributes')->nullable();
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
        Schema::dropIfExists('balises');
    }
};
