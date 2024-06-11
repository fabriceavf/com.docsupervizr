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
        Schema::create('createsitespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitespointeuse_id');

        });
        Schema::create('updatesitespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitespointeuse_id');

        });
        Schema::create('deletesitespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitespointeuse_id');

        });
        Schema::create('readsitespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sitespointeuse_id');

        });
        Schema::create('sitespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('pointeuse_id');
            $table->string('retirer')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('debut')->nullable();
            $table->string('fin')->nullable();
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
        Schema::dropIfExists('sitespointeuses');
    }
};
