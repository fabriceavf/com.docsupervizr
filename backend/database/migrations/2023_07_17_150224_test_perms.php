<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('DROP VIEW IF EXISTS perms');
        DB::statement("CREATE VIEW perms AS
                            SELECT CONCAT(permissions.id,'-',users.id) as id ,
                            permissions.name as permission_label,
                            permissions.nom as permission_nom,
                            permissions.id as permission_id,
                            permissions.updated_at as updated_at,
                            users.id as user_id,
                            users.nom,
                            users.prenom,
                            model_has_permissions.model_type as type,
                            permissions.deleted_at as deleted_at,
                            permissions.created_at as created_at
                            from permissions
                            JOIN users
                            LEFT JOIN model_has_permissions ON model_has_permissions.model_id=users.id AND model_has_permissions.permission_id=permissions.id;
                           ");
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
        DB::statement('DROP VIEW IF EXISTS perms');
    }
};
