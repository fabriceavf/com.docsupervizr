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
        Schema::create('alldatas',function (Blueprint $table) {
            $table->id();
            $table->string('cle')->nullable();
            $table->text('valeur')->nullable();
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
        Schema::dropIfExists('alldatas');
    }
};
