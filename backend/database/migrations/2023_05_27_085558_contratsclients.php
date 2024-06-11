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
        Schema::dropIfExists('contratsclients');
        Schema::create('contratsclients', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->comment('is_select_label')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });

        Schema::dropIfExists('contratssites');
        Schema::create('contratssites', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->unsignedBigInteger('contratsclient_id')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->unsignedBigInteger('prestation_id')->nullable();
            $table->integer('agentsjour');
            $table->integer('agentsnuit');
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });

        Schema::dropIfExists('contratspostes');
        Schema::create('contratspostes', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->unsignedBigInteger('contratssite_id')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->integer('jours')->default(5);
            $table->integer('agentsjour');
            $table->integer('agentsnuit');
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });

        Schema::dropIfExists('contratsagents');
        Schema::create('contratsagents', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->unsignedBigInteger('contratsposte_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
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
        Schema::dropIfExists('contratsclients');
        Schema::dropIfExists('contratssites');
        Schema::dropIfExists('contratspostes');
        Schema::dropIfExists('contratsagents');
    }
};
