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
        Schema::create('createpersonal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('personal_access_token_id');

        });
        Schema::create('updatepersonal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('personal_access_token_id');

        });
        Schema::create('deletepersonal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('personal_access_token_id');

        });
        Schema::create('readpersonal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('personal_access_token_id');

        });
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('identifiants_sadge')->nullable();
            $table->string('creat_by')->nullable();

            $table->index(['tokenable_type', 'tokenable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
