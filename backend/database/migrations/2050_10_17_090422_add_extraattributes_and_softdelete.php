<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraattributesAndSoftdelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        try{
        $tables = \DB::select('SHOW TABLES');


        $tables = array_map('current', $tables);
        foreach ($tables as $table){
            try{
                Schema::table($table, function (Blueprint $table) {
                    $table->schemalessAttributes('extra_attributes')->nullable();
                });
            }catch (\Throwable $e){ }
            try{
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }catch (\Throwable $e){ }
            try{
               Schema::table($table, function (Blueprint $table) {
                $table->string('identifiants_sadge')->nullable();
               });
            }catch (\Throwable $e){ }
            try{
                Schema::table($table, function (Blueprint $table) {
                 $table->string('creat_by')->nullable();
                });
             }catch (\Throwable $e){ }

        }

        try{
            Schema::create('extrasdatas', function (Blueprint $table) {
                $table->id();
                $table->string('cle')->nullable();
                $table->text('valeur')->nullable();
                $table->schemalessAttributes('extra_attributes')->nullable();
                $table->timestamps();
            });
        }catch (\Throwable $e){

        }

        try{
            Schema::create('role_has_permission', function (Blueprint $table) {
                $table->id();
            });
        }catch (\Throwable $e){

        }


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
        $tables = \DB::select('SHOW TABLES');


        $tables = array_map('current', $tables);
        foreach ($tables as $table){
            try{
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('extra_attributes');
                });
            }catch (\Throwable $e){

            }
        }
    }
}
