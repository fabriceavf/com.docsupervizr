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
        Schema::create('createechelons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('echelon_id');

        });
        Schema::create('updateechelons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('echelon_id');

        });
        Schema::create('deleteechelons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('echelon_id');

        });
        Schema::create('readechelons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('echelon_id');

        });
        Schema::create('echelons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('code')->nullable();
            $table->rememberToken();
            $table->json('extra_attributes')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('echelons');
    }
};
