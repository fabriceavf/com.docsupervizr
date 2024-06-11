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
        Schema::create('createclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');

        });
        Schema::create('updateclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');

        });
        Schema::create('deleteclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');

        });
        Schema::create('readclients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');

        });
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('code')->nullable();
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->timestamps();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
