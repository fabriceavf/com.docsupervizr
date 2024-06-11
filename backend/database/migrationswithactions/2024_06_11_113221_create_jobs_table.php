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
        Schema::create('createjobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id');

        });
        Schema::create('updatejobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id');

        });
        Schema::create('deletejobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id');

        });
        Schema::create('readjobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_id');

        });
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
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
        Schema::dropIfExists('jobs');
    }
};
