<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('balises', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('ref', 20);
            $table->string('libelle')->comment('is_select_label');
            $table->string('lat', 200);
            $table->string('lng', 200);
            $table->string('course', 20);
            $table->string('speed', 20);
            $table->string('icon_color', 50);
            $table->string('imei', 50);
            $table->string('heure', 20);
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
        Schema::dropIfExists('balises');
    }
}
