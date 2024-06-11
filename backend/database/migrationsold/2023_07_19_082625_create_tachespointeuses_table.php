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
        try{
        Schema::table('taches', function (Blueprint $table) {
            $table->dropColumn('pointeuse_id');
          });
        Schema::create('tachespointeuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tache_id');
            $table->unsignedBigInteger('pointeuse_id');
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
        Schema::table('taches', function (Blueprint $table) {
            $table->unsignedBigInteger('pointeuse_id');
        });
        Schema::dropIfExists('tachespointeuses');
    }
};
