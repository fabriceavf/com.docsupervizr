<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('documents', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('nom')->comment('is_select_label');
            $table->string('rubrique');
            $table->string('fichier');
            $table->unsignedBigInteger('agent_id')->nullable()->index('documents_agent_id_foreign');
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
        Schema::dropIfExists('documents');
    }
}
