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
        Schema::create('createfailed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('failed_job_id');

        });
        Schema::create('updatefailed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('failed_job_id');

        });
        Schema::create('deletefailed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('failed_job_id');

        });
        Schema::create('readfailed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('failed_job_id');

        });
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
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
        Schema::dropIfExists('failed_jobs');
    }
};
