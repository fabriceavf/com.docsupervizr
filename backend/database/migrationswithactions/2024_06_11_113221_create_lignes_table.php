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
        Schema::create('createlignes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ligne_id');

        });
        Schema::create('updatelignes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ligne_id');

        });
        Schema::create('deletelignes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ligne_id');

        });
        Schema::create('readlignes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ligne_id');

        });
        Schema::create('lignes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('tarifs')->nullable();
            $table->softDeletes();
            $table->string('creat_by')->nullable();
            $table->string('identifiants_sadge')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lignes');
    }
};
