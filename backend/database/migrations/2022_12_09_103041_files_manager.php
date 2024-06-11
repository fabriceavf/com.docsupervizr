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
        //        la table files
        Schema::create('files', function (Blueprint $table) {
            $table->id()->comment('is_select_label');
            $table->text('old_name');
            $table->text('new_name');
            $table->text('descriptions')->nullable()->comment('types_textarea');
            $table->string('extensions');
            $table->string('size');
            $table->string('path');
            $table->string('web_path');
            $table->integer('statut')->nullable();
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
        Schema::dropIfExists('files');
    }
};
