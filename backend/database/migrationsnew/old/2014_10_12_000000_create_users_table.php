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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nom')->nullable()->comment('is_require');
            $table->string('prenom')->nullable()->comment('is_require');
            $table->string('matricule')->nullable();
            $table->string('num_badge')->nullable();
            $table->string('date_naissance')->nullable()->comment('types_datetime');
            $table->string('num_cnss')->nullable();
            $table->string('num_cnamgs')->nullable();
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('photo')->nullable()->default('images/default_photo.jpg');
            $table->string('date_embauche')->nullable()->comment('types_datetime');
            $table->timestamp('download_date')->nullable()->comment('types_datetime');
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
            $table->unsignedBigInteger('site_id')->nullable();
            $table->unsignedBigInteger('situation_id')->nullable();
            $table->string('balise_id')->nullable();
            $table->unsignedBigInteger('fonction_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable()->comment('');
            $table->string('emp_code')->nullable();
            $table->string('nombre_enfant')->nullable();
            $table->string('num_dossier')->nullable();
            $table->unsignedBigInteger('online_id')->nullable();
             $table->unsignedBigInteger('type_id')->nullable();
             $table->unsignedBigInteger('faction_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
