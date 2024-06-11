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
        Schema::create('calendriers', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->comment('is_select_label');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('calendriers');
    }
};
