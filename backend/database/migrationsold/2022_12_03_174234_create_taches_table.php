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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('typestache_id');
            $table->string('libelle')->comment('is_select_label');
            $table->unsignedBigInteger('ville_id');
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });
        Schema::create('typestaches', function (Blueprint $table) {
        $table->id();
        $table->string('libelle')->nullable()->comment('is_select_label');
        $table->string('code')->nullable();
        $table->rememberToken();
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
        Schema::dropIfExists('taches');
        Schema::dropIfExists('typestaches');
    }
};
