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
        Schema::table('postes', function (Blueprint $table) {
            $table->unsignedBigInteger('postesarticle_id')->nullable();
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
        Schema::table('postes', function (Blueprint $table) {
            $table->dropColumn('postesarticle_id');
        });
    }
};
