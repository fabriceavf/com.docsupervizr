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
        Schema::create('createtypespointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typespointage_id');

        });
        Schema::create('updatetypespointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typespointage_id');

        });
        Schema::create('deletetypespointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typespointage_id');

        });
        Schema::create('readtypespointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typespointage_id');

        });
        Schema::create('typespointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->text('libelle')->nullable();
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
        Schema::dropIfExists('typespointages');
    }
};
