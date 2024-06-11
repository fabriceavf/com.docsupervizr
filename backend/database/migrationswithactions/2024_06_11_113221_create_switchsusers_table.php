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
        Schema::create('createswitchsusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('switchsuser_id');

        });
        Schema::create('updateswitchsusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('switchsuser_id');

        });
        Schema::create('deleteswitchsusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('switchsuser_id');

        });
        Schema::create('readswitchsusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('switchsuser_id');

        });
        Schema::create('switchsusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('old_type')->nullable();
            $table->string('new_type')->nullable();
            $table->string('action')->nullable();
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
        Schema::dropIfExists('switchsusers');
    }
};
