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
        Schema::create('createtypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesposte_id');

        });
        Schema::create('updatetypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesposte_id');

        });
        Schema::create('deletetypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesposte_id');

        });
        Schema::create('readtypespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesposte_id');

        });
        Schema::create('typespostes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('canCreate')->default(1);
            $table->integer('canUpdate')->default(1);
            $table->integer('canDelete')->default(1);
            $table->integer('maxagent')->nullable()->default(0);
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
        Schema::dropIfExists('typespostes');
    }
};
