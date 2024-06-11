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
        Schema::create('createpostespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postespointeuse_id');

        });
        Schema::create('updatepostespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postespointeuse_id');

        });
        Schema::create('deletepostespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postespointeuse_id');

        });
        Schema::create('readpostespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('postespointeuse_id');

        });
        Schema::create('postespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('poste_id');
            $table->unsignedBigInteger('pointeuse_id');
            $table->timestamps();
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
        Schema::dropIfExists('postespointeuses');
    }
};
