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
        Schema::create('createtypeseffectifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typeseffectif_id');

        });
        Schema::create('updatetypeseffectifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typeseffectif_id');

        });
        Schema::create('deletetypeseffectifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typeseffectif_id');

        });
        Schema::create('readtypeseffectifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typeseffectif_id');

        });
        Schema::create('typeseffectifs', function (Blueprint $table) {
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
            $table->string('champHide')->nullable();
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
        Schema::dropIfExists('typeseffectifs');
    }
};
