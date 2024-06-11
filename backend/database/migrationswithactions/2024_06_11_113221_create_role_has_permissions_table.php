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
        Schema::create('createrole_has_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_has_permission_id');

        });
        Schema::create('updaterole_has_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_has_permission_id');

        });
        Schema::create('deleterole_has_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_has_permission_id');

        });
        Schema::create('readrole_has_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_has_permission_id');

        });
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
            $table->string('creat_by')->nullable();
            $table->string('canCreate')->nullable();
            $table->string('canUpdate')->nullable();
            $table->string('canDelete')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_has_permissions');
    }
};
