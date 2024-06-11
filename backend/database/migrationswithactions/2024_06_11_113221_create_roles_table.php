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
        Schema::create('createroles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_id');

        });
        Schema::create('updateroles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_id');

        });
        Schema::create('deleteroles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_id');

        });
        Schema::create('readroles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_id');

        });
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->string('type')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
            $table->string('creat_by')->nullable();

            $table->unique(['name', 'guard_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
