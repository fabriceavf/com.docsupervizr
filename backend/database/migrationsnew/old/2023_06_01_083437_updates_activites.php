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

        Schema::table('activites', function (Blueprint $table) {
                $table->integer('duree')->default(0);
                $table->string('parent')->default(0);
                $table->unsignedBigInteger('user_id')->default(0);
                $table->boolean('has_child')->default(0);

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
        Schema::table('activites', function (Blueprint $table) {
            $table->dropColumn('duree');
            $table->dropColumn('parent');
            $table->dropColumn('user_id');
            $table->dropColumn('has_child');
        });
    }
};
