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
        Schema::create('statszones', function (Blueprint $table) {
            $table->id();
            $table->string('nom1')->nullable();
            $table->unsignedBigInteger('modelslistingnuit1_id')->nullable();
            $table->unsignedBigInteger('modelslistingjour1_id')->nullable();
            $table->string('nom2')->nullable();
            $table->unsignedBigInteger('modelslistingnuit2_id')->nullable();
            $table->unsignedBigInteger('modelslistingjour2_id')->nullable();
            $table->string('nom3')->nullable();
            $table->unsignedBigInteger('modelslistingnuit3_id')->nullable();
            $table->unsignedBigInteger('modelslistingjour3_id')->nullable();
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
        Schema::dropIfExists('statszones');
    }
};
