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
        Schema::create('createjoursferies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('joursferie_id');

        });
        Schema::create('updatejoursferies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('joursferie_id');

        });
        Schema::create('deletejoursferies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('joursferie_id');

        });
        Schema::create('readjoursferies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('joursferie_id');

        });
        Schema::create('joursferies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('raison')->nullable();
            $table->dateTime('debut')->nullable()->comment('types_datetime');
            $table->dateTime('fin')->nullable()->comment('types_datetime');
            $table->string('etats')->nullable();
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
        Schema::dropIfExists('joursferies');
    }
};
