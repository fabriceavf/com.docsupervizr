<?php

use App\Http\App;
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
        Schema::table('programmations', function (Blueprint $table) {
            $table->string('valideur_1')->nullable();
            $table->string('valideur_2')->nullable();
        });

        App::getValideur();
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
        Schema::table('programmations', function (Blueprint $table) {
            $table->dropColumn('valideur_1');
            $table->dropColumn('valideur_2');
        });
    }
};
