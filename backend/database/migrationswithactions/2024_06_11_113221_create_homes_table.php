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
        Schema::create('createhomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('home_id');

        });
        Schema::create('updatehomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('home_id');

        });
        Schema::create('deletehomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('home_id');

        });
        Schema::create('readhomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('home_id');

        });
        Schema::create('homes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user')->nullable();
            $table->text('etat')->nullable();
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
        Schema::dropIfExists('homes');
    }
};
