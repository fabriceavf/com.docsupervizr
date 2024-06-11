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
        Schema::dropIfExists("interventions");
        Schema::create('interventions',function(Blueprint $table){
            $table->id();
            $table->text('ref')->nullable();
            $table->string('site')->nullable();
            $table->string('agent')->nullable();
            $table->string('debut_prevu')->nullable();
            $table->string('debut_realise')->nullable();
            $table->string('fin_prevu')->nullable();
            $table->string('fin_realise')->nullable();
            $table->string('etats')->nullable();
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
        Schema::dropIfExists("interventions");
    }
};
