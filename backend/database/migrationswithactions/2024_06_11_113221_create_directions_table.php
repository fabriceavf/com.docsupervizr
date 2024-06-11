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
        Schema::create('createdirections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction_id');

        });
        Schema::create('updatedirections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction_id');

        });
        Schema::create('deletedirections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction_id');

        });
        Schema::create('readdirections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direction_id');

        });
        Schema::create('directions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('code')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('groupedirection_id')->nullable();
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
        Schema::dropIfExists('directions');
    }
};
