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
        try{
        Schema::create('programmationsrondes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->comment('is_select_label')->nullable();
            $table->text('description')->nullable()->comment('types_textarea');
            $table->timestamp('date_debut')->comment('types_datetime')->nullable();
            $table->timestamp('date_fin')->comment('types_datetime')->nullable();
            $table->string('default_heure_debut')->nullable();
            $table->string('default_heure_fin')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('statut')->default('En cours...');
            $table->string('type')->default('programmationsrondes');
            $table->string('postesbaladeur')->nullable();
            $table->timestamp('valider1')->nullable();
            $table->unsignedInteger('zone_id')->nullable();
            $table->timestamp('valider2')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable()->default(0);
            $table->string('etats')->nullable();
            $table->text('postes')->nullable();
            $table->string('min_pointage')->nullable();
            $table->longtext('Allclients')->nullable();
            $table->longtext('AllDatesInRange')->nullable();
            $table->longtext('Presents')->nullable();
            $table->longtext('Abscents')->nullable();
            $table->longtext('Presentsid')->nullable();
            $table->longtext('Abscentsid')->nullable();
            $table->unsignedBigInteger('user_id_2')->nullable();
            $table->unsignedBigInteger('user_id_3')->nullable();
            $table->unsignedBigInteger('user_id_4')->nullable();
            $table->string('valideur_1')->nullable();
            $table->string('valideur_2')->nullable();
            $table->string('creat_by')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('programmationsrondes');
    }
};
