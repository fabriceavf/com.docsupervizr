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
        Schema::create('horaires', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->comment('is_select_label');
            $table->time('debut');
            $table->time('fin');
            $table->string('tolerance')->nullable()->default(0);
            $table->string('type')->default('jour');
            $table->unsignedBigInteger('tache_id');
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
        Schema::dropIfExists('horaires');
    }
};
