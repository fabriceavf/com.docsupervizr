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
        Schema::create('createhistoriquemodelslistings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('historiquemodelslisting_id');

        });
        Schema::create('updatehistoriquemodelslistings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('historiquemodelslisting_id');

        });
        Schema::create('deletehistoriquemodelslistings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('historiquemodelslisting_id');

        });
        Schema::create('readhistoriquemodelslistings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('historiquemodelslisting_id');

        });
        Schema::create('historiquemodelslistings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action')->nullable()->comment('is_select_label');
            $table->text('ancien')->nullable();
            $table->text('nouveau')->nullable();
            $table->unsignedBigInteger('modelisting_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('historiquemodelslistings');
    }
};
