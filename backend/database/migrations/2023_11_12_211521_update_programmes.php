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
        Schema::table('programmes', function (Blueprint $table) {
            $table->text('pointages_rattacher_auto')->nullable();
            $table->text('pointages_rattacher_manuel')->nullable();
            $table->text('pointages_debut_auto')->nullable();
            $table->text('pointages_debut_manuel')->nullable();
            $table->text('pointages_fin_auto')->nullable();
            $table->text('pointages_fin_manuel')->nullable();
            $table->text('presence_declarer_auto')->nullable();
            $table->text('presence_declarer_manuel')->nullable();
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
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropColumn('pointages_rattacher_auto');
            $table->dropColumn('pointages_rattacher_manuel');
            $table->dropColumn('pointages_debut_auto');
            $table->dropColumn('pointages_debut_manuel');
            $table->dropColumn('pointages_fin_auto');
            $table->dropColumn('pointages_fin_manuel');
            $table->dropColumn('presence_declarer_auto');
            $table->dropColumn('presence_declarer_manuel');
        });
    }
};
