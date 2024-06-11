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
        Schema::create('createsexes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sexe_id');

        });
        Schema::create('updatesexes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sexe_id');

        });
        Schema::create('deletesexes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sexe_id');

        });
        Schema::create('readsexes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sexe_id');

        });
        Schema::create('sexes', function (Blueprint $table) {
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
        Schema::dropIfExists('sexes');
    }
};
