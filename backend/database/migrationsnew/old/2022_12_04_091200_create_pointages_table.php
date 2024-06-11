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
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->string('pointeuse')->nullable();
            $table->string('lieu')->nullable();
            $table->timestamp('debut_prevu')->nullable();
            $table->timestamp('fin_prevu')->nullable();
            $table->string('faction_horaire')->nullable();
            $table->timestamp('debut_reel')->nullable();
            $table->timestamp('debut_realise')->nullable();
            $table->timestamp('fin_realise')->nullable();
            $table->string('volume_realise')->nullable();
            $table->string('emp_code')->nullable();
            $table->text('motif')->nullable();
            $table->string('volume_prevu')->nullable();
            $table->boolean('actif')->default(true);
            $table->integer('est_valide')->default(true);
            $table->unsignedBigInteger('horaire_id')->nullable();
            $table->unsignedBigInteger('programme_id')->nullable();
            $table->float('tolerance')->nullable()->default(0);
            $table->boolean('est_attendu')->default(false);
            $table->string('etats')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('pointages');
    }
};
