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
        Schema::create('deplacements', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('ligne')->nullable();
            $table->string('moyenstransport')->nullable();
            $table->string('debut_prevu')->nullable();
            $table->string('fin_prevu')->nullable();
            $table->unsignedBigInteger('lignesmoyenstransport_id')->nullable();
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
        Schema::dropIfExists('deplacements');
    }
};
