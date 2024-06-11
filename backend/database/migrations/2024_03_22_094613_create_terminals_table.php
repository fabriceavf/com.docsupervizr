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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('is_select_label');
            $table->string('adresse_mac');
            $table->string('etat');
            $table->string('alimentation');
            $table->string('reseau');
            $table->unsignedBigInteger('voiture_id')->nullable();
            $table->string('creat_by')->nullable();
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
        Schema::dropIfExists('terminals');
    }
};
