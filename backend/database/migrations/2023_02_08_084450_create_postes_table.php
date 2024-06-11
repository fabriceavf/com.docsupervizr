<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        Schema::create('postes', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('code')->nullable();
            $table->string('libelle')->comment('is_select_label');
            $table->text('contrat')->nullable();
            $table->text('nature')->nullable();
            $table->text('coordonnees')->nullable();
            $table->unsignedBigInteger('site_id')->nullable()->index('postes_site_id_foreign');
            $table->unsignedBigInteger('pointeuse_id')->nullable()->index('postes_pointeuse_id_foreign');
            $table->timestamps();
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
        Schema::dropIfExists('postes');
    }
}
