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
        Schema::create('createbadges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('badge_id');

        });
        Schema::create('updatebadges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('badge_id');

        });
        Schema::create('deletebadges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('badge_id');

        });
        Schema::create('readbadges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('badge_id');

        });
        Schema::create('badges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
            $table->string('js')->nullable();
            $table->string('libelle')->nullable();
            $table->string('cs')->nullable();
            $table->string('node_version')->nullable();
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
        Schema::dropIfExists('badges');
    }
};
