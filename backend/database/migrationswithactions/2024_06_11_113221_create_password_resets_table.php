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
        Schema::create('createpassword_resets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('password_reset_id');

        });
        Schema::create('updatepassword_resets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('password_reset_id');

        });
        Schema::create('deletepassword_resets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('password_reset_id');

        });
        Schema::create('readpassword_resets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('password_reset_id');

        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->json('extra_attributes')->nullable();
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
        Schema::dropIfExists('password_resets');
    }
};
