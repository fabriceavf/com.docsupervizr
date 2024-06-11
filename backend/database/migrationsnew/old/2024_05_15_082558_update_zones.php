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
        try {
            Schema::table('zones', function (Blueprint $table) {
                $table->string('ville_id')->nullable();
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
            Schema::table('zones', function (Blueprint $table) {
                $table->dropColumn('ville_id');
            });
        } catch (\Throwable $e) {

        }
    }
};
