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
        Schema::table('postes', function (Blueprint $table) {
          $table->dropColumn('pointeuse_id');
        });
        Schema::create('postespointeuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poste_id');
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
        Schema::table('postes', function (Blueprint $table) {
            $table->unsignedBigInteger('pointeuse_id');
            //
        });
        Schema::dropIfExists('postespointeuses');
    }
};
