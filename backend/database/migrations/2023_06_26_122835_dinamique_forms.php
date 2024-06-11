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
        try{
        Schema::create('forms', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('description')->nullable();
            $table->text('childs')->nullable();
            $table->text('champs')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->string('creat_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('formschamps', function (Blueprint $table) {
            $table->id()->comment('is_select_key');
            $table->string('libelle')->nullable()->comment('is_select_label');
            $table->string('description')->nullable();
            $table->text('type')->nullable();
            $table->string('cle')->nullable();
            $table->string('width')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->string('creat_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('formsdatas', function (Blueprint $table) {
            $table->id();

            $table->text('libelle')->nullable();
            $table->string('parent')->nullable();
            $table->unsignedBigInteger('form_id')->nullable();
            for($i=0;$i<100;$i++){
                $table->text('cle'.$i)->nullable();
            }
            $table->schemalessAttributes('extra_attributes')->nullable();
            $table->string('creat_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('forms');
        Schema::dropIfExists('formschamps');
        Schema::dropIfExists('formsdatas');
    }
};
