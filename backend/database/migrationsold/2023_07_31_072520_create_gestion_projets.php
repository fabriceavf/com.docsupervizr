<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('projets', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->text('descriptions')->nullable();
            $table->timestamp('debut_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('debut_reel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_reel')->nullable()->comment('types_datetime');
            $table->string('creat_by')->nullable();
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });
        Schema::create('besoins', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->text('descriptions')->nullable();
            $table->timestamp('debut_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('debut_reel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_reel')->nullable()->comment('types_datetime');
            $table->unsignedBigInteger('projet_id')->nullable();
            $table->integer('evaluation')->default(0);
            $table->string('creat_by')->nullable();
            $table->string('valider')->nullable()->default('0');
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });
        Schema::create('actionsprevisionelles', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->text('descriptions')->nullable();
            $table->timestamp('debut_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('debut_reel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_reel')->nullable()->comment('types_datetime');
            $table->unsignedBigInteger('besoin_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->integer('evaluation')->default(0);
            $table->string('valider')->nullable()->default('0');
            $table->string('type')->nullable()->default('prevu');
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });
        Schema::create('actionsrealises', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->text('descriptions')->nullable();
            $table->timestamp('debut_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_previsionnel')->nullable()->comment('types_datetime');
            $table->timestamp('debut_reel')->nullable()->comment('types_datetime');
            $table->timestamp('fin_reel')->nullable()->comment('types_datetime');
            $table->unsignedBigInteger('actionsprevisionelle_id')->nullable();
            $table->string('creat_by')->nullable();
            $table->integer('evaluation')->default(0);
            $table->timestamps();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->softDeletes();
        });
     }catch (\Throwable $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actionsrealises');
        Schema::dropIfExists('actionsprevisionelles');
        Schema::dropIfExists('besoins');
        Schema::dropIfExists('projets');
    }
};
