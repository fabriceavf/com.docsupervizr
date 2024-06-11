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
        Schema::create('programmes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date')->nullable()->comment('types_datetime');
            $table->timestamp('debut_prevu')->nullable();
            $table->timestamp('fin_prevu')->nullable();
            $table->timestamp('debut_reel')->nullable();
            $table->timestamp('debut_realise')->nullable();
            $table->timestamp('fin_realise')->nullable();
            $table->double('volume_horaire', 8, 2)->nullable();
            $table->double('hs_base', 8, 2)->nullable();
            $table->double('hs_hors_faction', 8, 2)->nullable();
            $table->double('hs_in_faction', 8, 2)->nullable();
            $table->unsignedBigInteger('programmationsuser_id')->nullable();
            $table->unsignedBigInteger('horaire_id')->nullable();
            $table->string('etats')->default('En cours...');
            $table->integer('totalReel')->default(0);
            $table->integer('totalFictif')->default(0);
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('poste_id')->nullable()->default(0);
            $table->string('remplacant')->default('0');
            $table->string('type')->nullable();
            $table->integer('week')->nullable();
            $table->longText('user')->nullable();
            $table->longText('DayStatut')->nullable();
            $table->longText('Remplacantuser')->nullable();
            $table->longText('PresencesDeclarer')->nullable();
            $table->longText('AbscencesDeclarer')->nullable();
            $table->longText('EtatsDeclarer')->nullable();
            $table->longText('Totalpresent')->nullable();
            $table->longText('J1')->nullable();
            $table->longText('J2')->nullable();
            $table->longText('J3')->nullable();
            $table->longText('J4')->nullable();
            $table->longText('J5')->nullable();
            $table->longText('J6')->nullable();
            $table->longText('J7')->nullable();
            $table->longText('J8')->nullable();
            $table->longText('J9')->nullable();
            $table->longText('J10')->nullable();
            $table->longText('J11')->nullable();
            $table->longText('J12')->nullable();
            $table->longText('J13')->nullable();
            $table->longText('J14')->nullable();
            $table->longText('J15')->nullable();
            $table->longText('J16')->nullable();
            $table->longText('J17')->nullable();
            $table->longText('J18')->nullable();
            $table->longText('J19')->nullable();
            $table->longText('J20')->nullable();
            $table->longText('J21')->nullable();
            $table->longText('J22')->nullable();
            $table->longText('J23')->nullable();
            $table->longText('J24')->nullable();
            $table->longText('J25')->nullable();
            $table->longText('J26')->nullable();
            $table->longText('J27')->nullable();
            $table->longText('J28')->nullable();
            $table->longText('J29')->nullable();
            $table->longText('J30')->nullable();
            $table->longText('J31')->nullable();
            $table->unsignedInteger('deja_annaliser')->default(0);
            $table->text('pointages_rattacher_auto')->nullable();
            $table->text('pointages_rattacher_manuel')->nullable();
            $table->text('pointages_debut_auto')->nullable();
            $table->text('pointages_debut_manuel')->nullable();
            $table->text('pointages_fin_auto')->nullable();
            $table->text('pointages_fin_manuel')->nullable();
            $table->text('presence_declarer_auto')->nullable();
            $table->text('presence_declarer_manuel')->nullable();
            $table->unsignedBigInteger('programmation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('qualification_horaire')->nullable();
            $table->timestamp('fin_reel')->nullable();
            $table->unsignedBigInteger('typesheure_id')->nullable();
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
        Schema::dropIfExists('programmes');
    }
};
