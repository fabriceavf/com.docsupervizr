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
        Schema::dropIfExists('positions');
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('speed')->nullable();
            $table->string('icon_color')->nullable();
            $table->string('moyenstransportid')->nullable();
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
        Schema::dropIfExists('positions');
    }
};
