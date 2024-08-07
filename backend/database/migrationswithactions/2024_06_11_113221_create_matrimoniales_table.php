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
        Schema::create('creatematrimoniales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matrimoniale_id');

        });
        Schema::create('updatematrimoniales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matrimoniale_id');

        });
        Schema::create('deletematrimoniales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matrimoniale_id');

        });
        Schema::create('readmatrimoniales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matrimoniale_id');

        });
        Schema::create('matrimoniales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('matrimoniales');
    }
};
