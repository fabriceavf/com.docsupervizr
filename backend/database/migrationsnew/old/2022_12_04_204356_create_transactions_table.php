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
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();
            $table->string('bio_id')->nullable();
            $table->string('area_alias')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('card_no')->nullable();
            $table->string('terminal_alias')->nullable();
            $table->string('emp_code')->nullable();
            $table->date('punch_date')->nullable();
            $table->timestamp('punch_time')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('matricule')->nullable();
            $table->unsignedBigInteger('actif_id')->nullable();
            $table->unsignedBigInteger('nationalite_id')->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->unsignedBigInteger('echelon_id')->nullable();
            $table->unsignedBigInteger('sexe_id')->nullable();
            $table->unsignedBigInteger('matrimoniale_id')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('situation_id')->nullable();
            $table->unsignedBigInteger('balise_id')->nullable();
            $table->unsignedBigInteger('fonction_id')->nullable();
            $table->unsignedBigInteger('online_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('faction_id')->nullable();
            $table->unsignedBigInteger('pointeuse_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });
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
        Schema::dropIfExists('transactions');
    }
};
