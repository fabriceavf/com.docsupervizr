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
        try {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('first_name')->nullable();
                $table->dropColumn('last_name')->nullable();
                $table->dropColumn('nom')->nullable();
                $table->dropColumn('prenom')->nullable();
                $table->dropColumn('matricule')->nullable();
            });
        } catch (\Throwable $e) {

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::table('transactions', function (Blueprint $table) {

                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('nom')->nullable();
                $table->string('prenom')->nullable();
                $table->string('matricule')->nullable();
            });
        } catch (\Throwable $e) {

        }
    }
};
