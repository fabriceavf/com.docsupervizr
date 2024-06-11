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
                $table->dropColumn('situation_id')->nullable();
                $table->dropColumn('pointeuse_id')->nullable();
                $table->dropColumn('pointeusepostes')->nullable();
                $table->dropColumn('TachesPotentiels')->nullable();
                $table->dropColumn('PostesPotentiels')->nullable();
                $table->dropColumn('TotalPostes')->nullable();
                $table->dropColumn('TotalPostescouvert')->nullable();
                $table->dropColumn('TotalPostesnoncouvert')->nullable();
                $table->dropColumn('TotalPostessouscouvert')->nullable();
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

                $table->string('situation_id')->nullable();
                $table->string('pointeuse_id')->nullable();
                $table->string('pointeusepostes')->nullable();
                $table->string('TachesPotentiels')->nullable();
                $table->string('PostesPotentiels')->nullable();
                $table->string('TotalPostes')->nullable();
                $table->string('TotalPostescouvert')->nullable();
                $table->string('TotalPostesnoncouvert')->nullable();
                $table->string('TotalPostessouscouvert')->nullable();
            });
        } catch (\Throwable $e) {

        }
    }
};
