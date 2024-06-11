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
        Schema::create('createhorairestypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('horairestypesposte_id');

        });
        Schema::create('updatehorairestypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('horairestypesposte_id');

        });
        Schema::create('deletehorairestypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('horairestypesposte_id');

        });
        Schema::create('readhorairestypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('horairestypesposte_id');

        });
        Schema::create('horairestypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->time('debut')->nullable();
            $table->time('fin')->nullable();
            $table->unsignedBigInteger('typesposte_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('ordre')->nullable();
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
        Schema::dropIfExists('horairestypespostes');
    }
};
