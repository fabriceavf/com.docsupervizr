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
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->text('fichiers')->nullable();
            $table->text('liaisons')->nullable();
            $table->string('identifiant')->nullable();
            $table->string('etats')->default('non traiter')->nullable();
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
        Schema::dropIfExists('imports');
    }
};
