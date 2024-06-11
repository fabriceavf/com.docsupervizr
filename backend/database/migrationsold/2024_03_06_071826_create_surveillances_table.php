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
        Schema::create('surveillances', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable()->comment('is_select_label');
            $table->string('entite')->nullable()->comment('is_select_label');
            $table->string('entite_cle')->nullable();
            $table->text('ancien')->nullable();
            $table->text('nouveau')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip')->nullable()->comment('is_select_label');
            $table->text('details')->nullable();
            $table->string('navigateur')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->string('id_base')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->schemalessAttributes('extra_attributes')->nullable();
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
        Schema::dropIfExists('surveillances');
    }
};
