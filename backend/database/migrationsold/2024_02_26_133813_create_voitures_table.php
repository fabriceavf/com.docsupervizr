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
        Schema::create('voitures', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('plaque')->nullable();
            $table->string('capacite')->nullable();
            $table->softDeletes();
            $table->string('creat_by')->nullable();
            $table->string('identifiants_sadge')->nullable();
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
        Schema::dropIfExists('voitures');
    }
};
