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
        Schema::create('projets', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->text('descriptions')->nullable();
            $table->timestamp('debut_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('debut_reel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_reel')->nullable()->comment('types_datetime');
            $table->string('creat_by')->nullable();
            $table->timestamps();
            $table->json('extra_attributes')->nullable();
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
        Schema::dropIfExists('projets');
    }
};
