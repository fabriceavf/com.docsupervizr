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
            Schema::table('programmes', function (Blueprint $table) {
                $table->unsignedBigInteger('typesheure_id')->nullable();
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
        try {
            Schema::table('programmes', function (Blueprint $table) {
                $table->string('typesheure_id')->nullable();
            });
        }catch (\Throwable $e){

        }
    }
};
