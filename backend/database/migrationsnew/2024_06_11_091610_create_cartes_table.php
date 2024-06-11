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
        Schema::create('cartes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('uid_mifare')->nullable();
            $table->string('solde')->nullable();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('etats')->nullable();
            $table->softDeletes();
            $table->string('creat_by')->nullable();
            $table->string('identifiants_sadge')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartes');
    }
};
