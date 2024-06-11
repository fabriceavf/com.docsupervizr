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

        //



        Schema::create('abscences',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('raison')->nullable();
            $table->dateTime('debut')->nullable()->comment('types_datetime');
            $table->dateTime('fin')->nullable()->comment('types_datetime');
            $table->string('etats')->nullable();
            $table->unsignedBigInteger('typesabscence_id')->nullable();
             $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });

        Schema::create('typesabscences',function(Blueprint $table){
            $table->id();
            $table->text('libelle')->nullable()->comment('is_select_label');
            $table->unsignedBigInteger('soldable_id')->nullable();
            $table->unsignedBigInteger('variable_id')->nullable();
            $table->string('nombrejours')->nullable();
            $table->string('etats')->nullable();
             $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });

        Schema::create('soldables', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('code')->nullable();
            $table->rememberToken();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->timestamps();
        });

        Schema::create('variables', function (Blueprint $table) {
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
        //

        Schema::dropIfExists('conges');
    }
};
