<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('sites', function (Blueprint $table) {
                $table->id()->comment('is_select_key');
                $table->string('libelle')->comment('is_select_label');
                $table->unsignedBigInteger('client_id')->nullable()->index('sites_client_id_foreign');
                $table->unsignedBigInteger('zone_id')->nullable()->index('zones');
                $table->timestamps();
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
        Schema::dropIfExists('sites');
    }
}
