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
        Schema::create('createlogins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');

        });
        Schema::create('updatelogins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');

        });
        Schema::create('deletelogins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');

        });
        Schema::create('readlogins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id');

        });
        Schema::create('logins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->text('etat')->nullable();
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
        Schema::dropIfExists('logins');
    }
};
