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
        Schema::create('createsitessdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitessdeplacement_id');

        });
        Schema::create('updatesitessdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitessdeplacement_id');

        });
        Schema::create('deletesitessdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitessdeplacement_id');

        });
        Schema::create('readsitessdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitessdeplacement_id');

        });
        Schema::create('sitessdeplacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deplacement_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('durees')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('sitessdeplacements');
    }
};
