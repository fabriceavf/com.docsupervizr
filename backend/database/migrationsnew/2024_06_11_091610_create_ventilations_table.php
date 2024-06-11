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
        Schema::create('ventilations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('semaine')->nullable();
            $table->string('dimanche_date')->nullable();
            $table->string('lundi_date')->nullable();
            $table->string('mardi_date')->nullable();
            $table->string('mercredi_date')->nullable();
            $table->string('jeudi_date')->nullable();
            $table->string('vendredi_date')->nullable();
            $table->string('samedi_date')->nullable();
            $table->string('dimanche_horaire')->nullable();
            $table->string('lundi_horaire')->nullable();
            $table->string('mardi_horaire')->nullable();
            $table->string('mercredi_horaire')->nullable();
            $table->string('jeudi_horaire')->nullable();
            $table->string('vendredi_horaire')->nullable();
            $table->string('samedi_horaire')->nullable();
            $table->string('dimanche')->nullable();
            $table->string('lundi')->nullable();
            $table->string('mardi')->nullable();
            $table->string('mercredi')->nullable();
            $table->string('jeudi')->nullable();
            $table->string('vendredi')->nullable();
            $table->string('samedi')->nullable();
            $table->string('dimanche_pointage')->nullable();
            $table->string('lundi_pointage')->nullable();
            $table->string('mardi_pointage')->nullable();
            $table->string('mercredi_pointage')->nullable();
            $table->string('jeudi_pointage')->nullable();
            $table->string('vendredi_pointage')->nullable();
            $table->string('samedi_pointage')->nullable();
            $table->string('dimanche_collecter')->nullable();
            $table->string('lundi_collecter')->nullable();
            $table->string('mardi_collecter')->nullable();
            $table->string('mercredi_collecter')->nullable();
            $table->string('jeudi_collecter')->nullable();
            $table->string('vendredi_collecter')->nullable();
            $table->string('samedi_collecter')->nullable();
            $table->string('dimanche_depassement')->nullable();
            $table->string('lundi_depassement')->nullable();
            $table->string('mardi_depassement')->nullable();
            $table->string('mercredi_depassement')->nullable();
            $table->string('jeudi_depassement')->nullable();
            $table->string('vendredi_depassement')->nullable();
            $table->string('samedi_depassement')->nullable();
            $table->string('dimanche_programmer')->nullable();
            $table->string('lundi_programmer')->nullable();
            $table->string('mardi_programmer')->nullable();
            $table->string('mercredi_programmer')->nullable();
            $table->string('jeudi_programmer')->nullable();
            $table->string('vendredi_programmer')->nullable();
            $table->string('samedi_programmer')->nullable();
            $table->string('dimanche_retard')->nullable();
            $table->string('lundi_retard')->nullable();
            $table->string('mardi_retard')->nullable();
            $table->string('mercredi_retard')->nullable();
            $table->string('jeudi_retard')->nullable();
            $table->string('vendredi_retard')->nullable();
            $table->string('samedi_retard')->nullable();
            $table->unsignedBigInteger('programmation_id')->nullable();
            $table->double('total_programmer', 8, 2)->nullable();
            $table->double('total_colecter', 8, 2)->nullable();
            $table->double('total_depassement', 8, 2)->nullable();
            $table->double('hs15', 8, 2)->nullable()->default(0);
            $table->double('hs26', 8, 2)->nullable()->default(0);
            $table->double('hs55', 8, 2)->nullable()->default(0);
            $table->double('hs30', 8, 2)->nullable()->default(0);
            $table->double('hs60', 8, 2)->nullable()->default(0);
            $table->double('hs115', 8, 2)->nullable()->default(0);
            $table->double('hs130', 8, 2)->nullable()->default(0);
            $table->double('total', 8, 2)->nullable()->default(0);
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
        Schema::dropIfExists('ventilations');
    }
};
