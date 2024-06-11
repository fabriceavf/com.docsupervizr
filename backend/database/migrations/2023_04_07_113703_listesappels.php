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

        Schema::create('listesappels', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->timestamp('debut')->nullable()->comment('types_datetime');
            $table->timestamp('fin')->nullable()->comment('types_datetime');
            $table->string('etats')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });
        Schema::create('listesjours',function (Blueprint $table) {
            $table->id();
            $table->string('rand')->nullable();
            $table->timestamp('jour')->nullable();
            $table->unsignedBigInteger('listesappel_id')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('listesappelsjours',function (Blueprint $table) {
            $table->id();
            $table->string('rand')->nullable();
            $table->timestamp('jour01')->nullable();
            $table->timestamp('jour02')->nullable();
            $table->timestamp('jour03')->nullable();
            $table->timestamp('jour04')->nullable();
            $table->timestamp('jour05')->nullable();
            $table->timestamp('jour06')->nullable();
            $table->timestamp('jour07')->nullable();
            $table->timestamp('jour08')->nullable();
            $table->timestamp('jour09')->nullable();
            $table->timestamp('jour10')->nullable();
            $table->timestamp('jour11')->nullable();
            $table->timestamp('jour12')->nullable();
            $table->timestamp('jour13')->nullable();
            $table->timestamp('jour14')->nullable();
            $table->timestamp('jour15')->nullable();
            $table->timestamp('jour16')->nullable();
            $table->timestamp('jour17')->nullable();
            $table->timestamp('jour18')->nullable();
            $table->timestamp('jour19')->nullable();
            $table->timestamp('jour20')->nullable();
            $table->timestamp('jour21')->nullable();
            $table->timestamp('jour22')->nullable();
            $table->timestamp('jour23')->nullable();
            $table->timestamp('jour24')->nullable();
            $table->timestamp('jour25')->nullable();
            $table->timestamp('jour26')->nullable();
            $table->timestamp('jour27')->nullable();
            $table->timestamp('jour28')->nullable();
            $table->timestamp('jour29')->nullable();
            $table->timestamp('jour30')->nullable();
            $table->timestamp('jour31')->nullable();
            $table->timestamp('tache01')->nullable();
            $table->timestamp('tache02')->nullable();
            $table->timestamp('tache03')->nullable();
            $table->timestamp('tache04')->nullable();
            $table->timestamp('tache05')->nullable();
            $table->timestamp('tache06')->nullable();
            $table->timestamp('tache07')->nullable();
            $table->timestamp('tache08')->nullable();
            $table->timestamp('tache09')->nullable();
            $table->timestamp('tache10')->nullable();
            $table->timestamp('tache11')->nullable();
            $table->timestamp('tache12')->nullable();
            $table->timestamp('tache13')->nullable();
            $table->timestamp('tache14')->nullable();
            $table->timestamp('tache15')->nullable();
            $table->timestamp('tache16')->nullable();
            $table->timestamp('tache17')->nullable();
            $table->timestamp('tache18')->nullable();
            $table->timestamp('tache19')->nullable();
            $table->timestamp('tache20')->nullable();
            $table->timestamp('tache21')->nullable();
            $table->timestamp('tache22')->nullable();
            $table->timestamp('tache23')->nullable();
            $table->timestamp('tache24')->nullable();
            $table->timestamp('tache25')->nullable();
            $table->timestamp('tache26')->nullable();
            $table->timestamp('tache27')->nullable();
            $table->timestamp('tache28')->nullable();
            $table->timestamp('tache29')->nullable();
            $table->timestamp('tache30')->nullable();
            $table->timestamp('tache31')->nullable();
            $table->unsignedBigInteger('listesappel_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('listesappels');
        Schema::dropIfExists('listesjours');
        Schema::dropIfExists('listesappelsjours');
    }
};
