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
//        Schema::create('programmations', function (Blueprint $table) {
//            $table->id();
//            $table->string('semaine')->comment('is_select_label');
//            $table->timestamp('date_debut')->comment('types_datetime')->nullable();
//            $table->timestamp('date_fin')->comment('types_datetime')->nullable();
//            $table->unsignedBigInteger('user_id')->nullable();
//            $table->unsignedBigInteger('tache_id')->nullable();
//            $table->string('statut')->default('En cours...');
//            $table->schemalessAttributes('extra_attributes')->nullable();
//            $table->timestamps();
//        });
        Schema::create('programmations', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->comment('is_select_label');
            $table->text('description')->nullable()->comment('types_textarea');
            $table->timestamp('date_debut')->comment('types_datetime')->nullable();
            $table->timestamp('date_fin')->comment('types_datetime')->nullable();
            $table->string('default_heure_debut')->nullable();
            $table->string('default_heure_fin')->nullable();
            $table->unsignedBigInteger('tache_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('statut')->default('En cours...');
            $table->string('type')->default('programmations');
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });
        Schema::create('programmationsusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('programmation_id')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable()->comment('types_datetime');
            $table->timestamp('debut_prevu')->nullable();
            $table->timestamp('fin_prevu')->nullable();
            $table->timestamp('debut_reel')->nullable();
            $table->timestamp('debut_realise')->nullable();
            $table->timestamp('fin_realise')->nullable();
            $table->float('volume_horaire')->nullable();
            $table->float('hs_base')->nullable();
            $table->float('hs_hors_faction')->nullable();
            $table->float('hs_in_faction')->nullable();
            $table->unsignedBigInteger('programmationsuser_id')->nullable();
            $table->unsignedBigInteger('horaire_id')->nullable();
            $table->string('etats')->default('En cours...');
            $table->integer('totalReel')->default(0);
            $table->integer('totalFictif')->default(0);
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });
        Schema::create('preuves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programme_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamp('punch_time')->nullable();
            $table->string('type')->nullable()->default('fictif');
            $table->string('role')->nullable();
            $table->string('etats')->default('En cours...');
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
        Schema::dropIfExists('programmations');
    }
};
