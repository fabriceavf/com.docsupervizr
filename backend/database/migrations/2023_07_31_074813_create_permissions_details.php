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
        Schema::create('permissionsdetails', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();
            $table->string('table')->nullable();
            $table->string('creat_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('permissionsdetails');
    }
};
