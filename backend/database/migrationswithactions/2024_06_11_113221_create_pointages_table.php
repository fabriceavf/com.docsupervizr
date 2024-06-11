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
        Schema::create('createpointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointage_id');

        });
        Schema::create('updatepointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointage_id');

        });
        Schema::create('deletepointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointage_id');

        });
        Schema::create('readpointages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointage_id');

        });
        Schema::create('pointages', function (Blueprint $table) {
            $table->bigIncrements('id');
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
            $table->integer('est_valide')->default(1);
            $table->unsignedBigInteger('horaire_id')->nullable();
            $table->unsignedBigInteger('programme_id')->nullable();
            $table->double('tolerance', 8, 2)->nullable()->default(0);
            $table->boolean('est_attendu')->default(false);
            $table->string('etats')->nullable();
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('pointages');
    }
};
