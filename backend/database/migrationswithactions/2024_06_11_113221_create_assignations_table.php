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
        Schema::create('createassignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assignation_id');

        });
        Schema::create('updateassignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assignation_id');

        });
        Schema::create('deleteassignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assignation_id');

        });
        Schema::create('readassignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assignation_id');

        });
        Schema::create('assignations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->string('user_id')->nullable();
            $table->string('carte_id')->nullable();
            $table->string('debut')->nullable();
            $table->string('fin')->nullable();
            $table->string('creat_by')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignations');
    }
};
