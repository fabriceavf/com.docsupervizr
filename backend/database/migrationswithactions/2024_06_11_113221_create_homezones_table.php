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
        Schema::create('createhomezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('homezone_id');

        });
        Schema::create('updatehomezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('homezone_id');

        });
        Schema::create('deletehomezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('homezone_id');

        });
        Schema::create('readhomezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('homezone_id');

        });
        Schema::create('homezones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('modelslisting_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('modelslisting')->nullable();
            $table->string('effectifsjour')->default('0');
            $table->string('presentsjour')->default('0');
            $table->string('effectifsnuit')->default('0');
            $table->string('presentsnuit')->default('0');
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
        Schema::dropIfExists('homezones');
    }
};
