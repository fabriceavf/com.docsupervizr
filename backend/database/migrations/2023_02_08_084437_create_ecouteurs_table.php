<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcouteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('ecouteurs', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('avant')->nullable();
            $table->string('apres')->nullable();
            $table->string('attribut');
            $table->timestamps();
            $table->unsignedBigInteger('agent_id')->nullable()->index('ecouteurs_agent_id_foreign');
            $table->unsignedBigInteger('user_id')->nullable()->index('ecouteurs_user_id_foreign');
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
        Schema::dropIfExists('ecouteurs');
    }
}
