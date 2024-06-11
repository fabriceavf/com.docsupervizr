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

        Schema::dropIfExists('logs');
        Schema::create('logs', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('action')->nullable()->comment('is_select_label');
            $table->string('ip')->nullable()->comment('is_select_label');
            $table->text('details')->nullable();
            $table->string('navigateur')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->schemalessAttributes('extra_attributes')->nullable();;
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

        Schema::dropIfExists('logs');
    }
};
