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
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('libelle')->comment('is_select_label');
            $table->unsignedBigInteger('client_id')->nullable()->index('sites_client_id_foreign');
            $table->unsignedBigInteger('zone_id')->nullable()->index('zones');
            $table->timestamps();
            $table->unsignedBigInteger('pointeuse_id')->nullable();
            $table->longText('NbrsJours')->nullable();
            $table->longText('NbrsNuits')->nullable();
            $table->string('type')->nullable();
            $table->string('pastille')->nullable();
            $table->unsignedBigInteger('typessite_id')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
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
        Schema::dropIfExists('sites');
    }
};
