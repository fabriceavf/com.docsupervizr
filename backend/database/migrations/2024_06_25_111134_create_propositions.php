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
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->string('taches_id');
            $table->date('date')->nullable();
            $table->string('proposition')->nullable();
            $table->string('etats')->nullable();
            $table->string('reponses')->nullable();
            $table->date('debut')->nullable();
            $table->date('fin')->nullable();
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
        Schema::dropIfExists('propositions');
    }
};
