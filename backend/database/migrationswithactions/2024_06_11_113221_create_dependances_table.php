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
        Schema::create('createdependances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dependance_id');

        });
        Schema::create('updatedependances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dependance_id');

        });
        Schema::create('deletedependances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dependance_id');

        });
        Schema::create('readdependances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dependance_id');

        });
        Schema::create('dependances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('badge_id')->nullable();
            $table->longText('libelle')->nullable();
            $table->timestamps();
            $table->string('version')->nullable();
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
        Schema::dropIfExists('dependances');
    }
};
