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
        Schema::create('analysespointeuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pointeuses')->nullable();
            $table->string('semaine')->nullable();
            $table->string('lun')->nullable()->default('0');
            $table->string('mar')->nullable()->default('0');
            $table->string('mer')->nullable()->default('0');
            $table->string('jeu')->nullable()->default('0');
            $table->string('ven')->nullable()->default('0');
            $table->string('sam')->nullable()->default('0');
            $table->string('dim')->nullable()->default('0');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('analysespointeuses');
    }
};
