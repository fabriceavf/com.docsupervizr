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
        Schema::create('trajets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->string('distance')->nullable();
            $table->softDeletes();
            $table->string('creat_by')->nullable();
            $table->string('identifiants_sadge')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('durees')->nullable();
            $table->string('ordre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trajets');
    }
};
