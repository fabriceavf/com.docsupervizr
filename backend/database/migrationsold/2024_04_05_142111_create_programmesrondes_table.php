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
        Schema::create('programmesrondes', function (Blueprint $table) {
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
            $table->unsignedBigInteger('poste_id')->nullable()->default(0);
            $table->string('remplacant')->default(0);
            $table->string('type')->nullable();
            $table->integer('week')->nullable();
            $table->longtext('user')->nullable();
            $table->longtext('DayStatut')->nullable();
            $table->longtext('Remplacantuser')->nullable();
            $table->longtext('PresencesDeclarer')->nullable();
            $table->longtext('AbscencesDeclarer')->nullable();
            $table->longtext('EtatsDeclarer')->nullable();
            $table->longtext('Totalpresent')->nullable();
            $table->longtext('J1')->nullable();
            $table->longtext('J2')->nullable();
            $table->longtext('J3')->nullable();
            $table->longtext('J4')->nullable();
            $table->longtext('J5')->nullable();
            $table->longtext('J6')->nullable();
            $table->longtext('J7')->nullable();
            $table->longtext('J8')->nullable();
            $table->longtext('J9')->nullable();
            $table->longtext('J10')->nullable();
            $table->longtext('J11')->nullable();
            $table->longtext('J12')->nullable();
            $table->longtext('J13')->nullable();
            $table->longtext('J14')->nullable();
            $table->longtext('J15')->nullable();
            $table->longtext('J16')->nullable();
            $table->longtext('J17')->nullable();
            $table->longtext('J18')->nullable();
            $table->longtext('J19')->nullable();
            $table->longtext('J20')->nullable();
            $table->longtext('J21')->nullable();
            $table->longtext('J22')->nullable();
            $table->longtext('J23')->nullable();
            $table->longtext('J24')->nullable();
            $table->longtext('J25')->nullable();
            $table->longtext('J26')->nullable();
            $table->longtext('J27')->nullable();
            $table->longtext('J28')->nullable();
            $table->longtext('J29')->nullable();
            $table->longtext('J30')->nullable();
            $table->longtext('J31')->nullable();
            $table->unsignedInteger('deja_annaliser')->default(0);
            $table->text('pointages_rattacher_auto')->nullable();
            $table->text('pointages_rattacher_manuel')->nullable();
            $table->text('pointages_debut_auto')->nullable();
            $table->text('pointages_debut_manuel')->nullable();
            $table->text('pointages_fin_auto')->nullable();
            $table->text('pointages_fin_manuel')->nullable();
            $table->text('presence_declarer_auto')->nullable();
            $table->text('presence_declarer_manuel')->nullable();
            $table->unsignedBigInteger('programmationsronde_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('programmesrondes');
    }
};
