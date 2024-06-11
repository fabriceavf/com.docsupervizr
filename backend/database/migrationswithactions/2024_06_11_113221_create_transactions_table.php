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
        Schema::create('createtransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id');

        });
        Schema::create('updatetransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id');

        });
        Schema::create('deletetransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id');

        });
        Schema::create('readtransactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id');

        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bio_id')->nullable();
            $table->string('area_alias')->nullable();
            $table->string('card_no')->nullable();
            $table->string('terminal_alias')->nullable();
            $table->string('emp_code')->nullable();
            $table->date('punch_date')->nullable();
            $table->timestamp('punch_time')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->boolean('etats')->nullable()->default(false);
            $table->boolean('annuler')->default(false);
            $table->string('type')->default('auto');
            $table->boolean('traiter')->default(false);
            $table->boolean('verification')->default(true);
            $table->integer('rechercheetape')->default(0);
            $table->time('heure')->nullable();
            $table->unsignedBigInteger('identification_id')->nullable();
            $table->unsignedBigInteger('controlleursacce_id')->nullable();
            $table->string('carte_id')->nullable();
            $table->string('cout')->nullable();
            $table->string('ligne_id')->nullable();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
            $table->string('creat_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
