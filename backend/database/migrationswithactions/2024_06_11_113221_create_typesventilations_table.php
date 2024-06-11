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
        Schema::create('createtypesventilations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesventilation_id');

        });
        Schema::create('updatetypesventilations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesventilation_id');

        });
        Schema::create('deletetypesventilations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesventilation_id');

        });
        Schema::create('readtypesventilations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typesventilation_id');

        });
        Schema::create('typesventilations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
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
        Schema::dropIfExists('typesventilations');
    }
};
