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
        Schema::create('createsurveillances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surveillance_id');

        });
        Schema::create('updatesurveillances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surveillance_id');

        });
        Schema::create('deletesurveillances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surveillance_id');

        });
        Schema::create('readsurveillances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('surveillance_id');

        });
        Schema::create('surveillances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action')->nullable()->comment('is_select_label');
            $table->string('entite')->nullable()->comment('is_select_label');
            $table->string('entite_cle')->nullable();
            $table->text('ancien')->nullable();
            $table->text('nouveau')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip')->nullable()->comment('is_select_label');
            $table->text('details')->nullable();
            $table->string('navigateur')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->string('id_base')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->json('extra_attributes')->nullable();
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
        Schema::dropIfExists('surveillances');
    }
};
