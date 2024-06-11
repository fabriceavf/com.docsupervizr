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
        Schema::create('createextrasdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('extrasdata_id');

        });
        Schema::create('updateextrasdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('extrasdata_id');

        });
        Schema::create('deleteextrasdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('extrasdata_id');

        });
        Schema::create('readextrasdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('extrasdata_id');

        });
        Schema::create('extrasdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cle')->nullable();
            $table->text('valeur')->nullable();
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
        Schema::dropIfExists('extrasdatas');
    }
};
