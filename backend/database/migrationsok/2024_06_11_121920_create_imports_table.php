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
        Schema::create('imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->text('liaisons')->nullable();
            $table->string('identifiant')->nullable();
            $table->string('etats')->nullable()->default('non traiter');
            $table->string('creat_by')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->string('file');
            $table->string('create')->nullable();
            $table->string('update')->nullable();
            $table->string('delete')->nullable();
            $table->string('valider')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('typesposte_id')->nullable();
            $table->unsignedBigInteger('typeseffectif_id')->nullable();
            $table->unsignedBigInteger('typespointage_id')->nullable();
            $table->string('typespointages')->nullable();
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
        Schema::dropIfExists('imports');
    }
};
