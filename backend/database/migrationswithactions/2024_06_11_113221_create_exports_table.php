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
        Schema::create('createexports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('export_id');

        });
        Schema::create('updateexports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('export_id');

        });
        Schema::create('deleteexports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('export_id');

        });
        Schema::create('readexports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('export_id');

        });
        Schema::create('exports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->string('lien')->nullable();
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
        Schema::dropIfExists('exports');
    }
};
