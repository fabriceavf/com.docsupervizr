<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
//        Schema::create('programmes', function (Blueprint $table) {
//            $table->id();
//            $table->string('dimanche', 50);
//            $table->string('lundi', 50);
//            $table->string('mardi', 50);
//            $table->string('mercredi', 50);
//            $table->string('jeudi', 50);
//            $table->string('vendredi', 50);
//            $table->string('samedi', 50);
//            $table->string('statut')->default('En attente');
//            $table->boolean('actif')->default(false);
//            $table->unsignedBigInteger('tache_id')->nullable()->default(0);
//            $table->unsignedBigInteger('programmation_id')->nullable();
//            $table->unsignedBigInteger('user_id')->nullable();
//            $table->schemalessAttributes('extra_attributes')->nullable();
//            $table->timestamps();
//        });
     }catch (\Throwable $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programmes');
    }
};
