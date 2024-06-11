<?php

namespace App\Providers;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Throwable;
use View;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $folder = Helpers::getMenuName();
//        dump($folder);
        $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/verticalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        $menus = $horizontalMenuData->menu;
        $newMenus = [];
        $hasSubmenu = false;
        $i = 0;
        while (($i == 0 || $hasSubmenu)) {
            $i++;
            $hasSubmenu = false;
            foreach ($menus as $menu) {
                if (!empty($menu->submenu)) {
                    $hasSubmenu = true;
                    foreach ($menu->submenu as $sousMenu) {
                        $newMenus[] = $sousMenu;
                    }

                } else {
                    $newMenus[] = $menu;
                }
            }
            $menus = $newMenus;

        }
        $menus = collect($menus);
        $menusPermission = $menus->pluck('permission')->filter(fn($data) => !empty($data));

        try {

//        je recupere tous les id de permissions de lecture qui nexiste pas dans le menu
            $idPermissionsQuonDoitSupprimer = DB::table('permissions')->where('name', 'like', 'Voir%')->whereNotIn('name', $menusPermission)->pluck('id')->toArray();
//        je supprime les role_has_permissions
            DB::table('role_has_permissions')->whereIn('permission_id', $idPermissionsQuonDoitSupprimer)->delete();
//        je supprime les permissions
            DB::table('permissions')->whereIn('id', $idPermissionsQuonDoitSupprimer)->delete();


            foreach ($menusPermission as $permission) {
                try {
                    if (DB::table('permissions')->where(['name' => $permission, 'guard_name' => 'web'])->count() == 0) {
                        DB::table('permissions')->insert(['name' => $permission, 'guard_name' => 'web', 'created_at' => now()]);
                    }

                } catch (Throwable $e) {

                }

            }
            DB::table('permissions')->where('name', 'like', 'Editer des %')->delete();
            DB::table('permissions')->where('name', 'like', 'Supprimer des %')->delete();
            foreach (DB::table('permissions')->where('name', 'like', 'Creer des %')->cursor() as $oldPerm) {
                DB::table('permissions')
                    ->where('id', $oldPerm->id)
                    ->update([
                        'name' => Str::replace('Creer des ', '', $oldPerm->name)
                    ]);
            }
        } catch (Throwable $e) {

        }

        // Share all menuData to all the views
        View::share('menuData', [$horizontalMenuData, $horizontalMenuData]);
    }
}
