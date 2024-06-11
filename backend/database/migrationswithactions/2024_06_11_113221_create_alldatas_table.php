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
        Schema::create('createalldatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alldata_id');

        });
        Schema::create('updatealldatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alldata_id');

        });
        Schema::create('deletealldatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alldata_id');

        });
        Schema::create('readalldatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alldata_id');

        });
        Schema::create('alldatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cle')->nullable();
            $table->text('valeur')->nullable();
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
        Schema::dropIfExists('alldatas');
    }
};
