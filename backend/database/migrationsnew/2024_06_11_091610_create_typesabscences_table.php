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
        Schema::create('typesabscences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('libelle')->nullable()->comment('is_select_label');
            $table->unsignedBigInteger('soldable_id')->nullable();
            $table->unsignedBigInteger('variable_id')->nullable();
            $table->string('nombrejours')->nullable();
            $table->string('etats')->nullable();
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
        Schema::dropIfExists('typesabscences');
    }
};
