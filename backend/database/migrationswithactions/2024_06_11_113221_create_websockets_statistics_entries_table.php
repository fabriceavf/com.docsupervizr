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
        Schema::create('createwebsockets_statistics_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('websockets_statistics_entrie_id');

        });
        Schema::create('updatewebsockets_statistics_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('websockets_statistics_entrie_id');

        });
        Schema::create('deletewebsockets_statistics_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('websockets_statistics_entrie_id');

        });
        Schema::create('readwebsockets_statistics_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('websockets_statistics_entrie_id');

        });
        Schema::create('websockets_statistics_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id');
            $table->integer('peak_connection_count');
            $table->integer('websocket_message_count');
            $table->integer('api_message_count');
            $table->timestamps();
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
        Schema::dropIfExists('websockets_statistics_entries');
    }
};
