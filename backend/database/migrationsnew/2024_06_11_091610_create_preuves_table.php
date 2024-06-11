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
        Schema::create('preuves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('programme_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamp('punch_time')->nullable();
            $table->string('type')->nullable()->default('fictif');
            $table->string('role')->nullable();
            $table->string('etats')->default('En cours...');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->string('valide')->default('1');
            $table->text('remarque')->default('');
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
        Schema::dropIfExists('preuves');
    }
};
