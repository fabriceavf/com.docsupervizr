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
        Schema::create('createconfigurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('configuration_id');

        });
        Schema::create('updateconfigurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('configuration_id');

        });
        Schema::create('deleteconfigurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('configuration_id');

        });
        Schema::create('readconfigurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('configuration_id');

        });
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cle')->nullable();
            $table->text('valeur')->nullable();
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
        Schema::dropIfExists('configurations');
    }
};
