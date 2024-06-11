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
        Schema::create('createlistingsetats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('listingsetat_id');

        });
        Schema::create('updatelistingsetats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('listingsetat_id');

        });
        Schema::create('deletelistingsetats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('listingsetat_id');

        });
        Schema::create('readlistingsetats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('listingsetat_id');

        });
        Schema::create('listingsetats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listingsjour_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('present')->nullable()->default('non');
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
        Schema::dropIfExists('listingsetats');
    }
};
