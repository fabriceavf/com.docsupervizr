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


        Schema::create('ventilations', function (Blueprint $table) {
            $table->id();
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
            $table->float('total_programmer')->nullable();
            $table->float('total_colecter')->nullable();
            $table->float('total_depassement')->nullable();
            $table->float('hs15')->nullable()->default(0);
            $table->float('hs26')->nullable()->default(0);
            $table->float('hs55')->nullable()->default(0);
            $table->float('hs30')->nullable()->default(0);
            $table->float('hs60')->nullable()->default(0);
            $table->float('hs115')->nullable()->default(0);
            $table->float('hs130')->nullable()->default(0);
            $table->float('total')->nullable()->default(0);

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
        Schema::dropIfExists('ventilations');
        Schema::dropIfExists('ventilationsdetails');
    }

};
