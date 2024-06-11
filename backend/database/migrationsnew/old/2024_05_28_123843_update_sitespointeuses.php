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
            Schema::table('sitespointeuses', function (Blueprint $table) {
                $table->string('debut')->nullable();
                $table->string('fin')->nullable();
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
        Schema::table('sitespointeuses', function (Blueprint $table) {
            $table->dropColumn('debut');
            $table->dropColumn('fin');
        });
    }
};
