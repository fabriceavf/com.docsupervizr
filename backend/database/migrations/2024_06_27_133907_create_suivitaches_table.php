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
        Schema::dropIfExists('suivitaches');
        Schema::create('suivitaches', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('priorite')->nullable();
            $table->date('date_demande')->nullable();
            $table->date('deadline')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('faisabilite')->nullable();
            $table->text('commentaire')->nullable();
            $table->unsignedBigInteger('projet_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
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
        Schema::dropIfExists('suivitaches');
    }
};
