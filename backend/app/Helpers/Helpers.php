<?php

namespace App\Helpers;

use Config;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Stancl\Tenancy\Contracts\Tenant;
use Throwable;

class Helpers
{
    public static function applClasses()
    {
        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'full',
            'showMenu' => true,
            'bodyClass' => '',
            'bodyStyle' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'en',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, config('custom.custom'));

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'bodyStyle' => $data['bodyStyle'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function getAsset($path)
    {
        return url($path);

    }

    public static function getMix($path, $manifestDirectory = '')
    {

        static $manifests = [];

        if (!str_starts_with($path, '/')) {
            $path = "/{$path}";
        }

        if ($manifestDirectory && !str_starts_with($manifestDirectory, '/')) {
            $manifestDirectory = "/{$manifestDirectory}";
        }

        if (false) {
            $url = rtrim(file_get_contents(public_path($manifestDirectory . '/hot')));

            $customUrl = app('config')->get('app.mix_hot_proxy_url');

            if (!empty($customUrl)) {
                return new HtmlString("{$customUrl}{$path}");
            }

            if (Str::startsWith($url, ['http://', 'https://'])) {
                return new HtmlString(Str::after($url, ':') . $path);
            }

            return new HtmlString("//localhost:8080{$path}");
        }

        $manifestPath = public_path($manifestDirectory . '/mix-manifest.json');

        if (!isset($manifests[$manifestPath])) {
            if (!is_file($manifestPath)) {
                throw new Exception("Mix manifest not found at: {$manifestPath}");
            }

            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }

        $manifest = $manifests[$manifestPath];

        if (!isset($manifest[$path])) {
            $exception = new Exception("Unable to locate Mix file: {$path}.");

            if (!app('config')->get('app.debug')) {
                report($exception);

                return $path;
            } else {
                throw $exception;
            }
        }

        return new HtmlString(app('config')->get('app.mix_url') . $manifestDirectory . $manifest[$path]);

    }

    public static function canShowMenu($menu)
    {

        //        on recupere les modules du client
        $name = Str::replace(' ', '', (Str::lower(Helpers::getAppName())));
        $fileName = '/Params/' . $name . '_db.json';
        $modules = [];
        try {
            $dbConnectionParams = file_get_contents(base_path($fileName));
            $dbConnectionParams = json_decode($dbConnectionParams, true);
            $modules = $dbConnectionParams['modules'];
        } catch (\Throwable $e) {

        }
        if (count($modules) == 0) {
            $modules[] = 'Effectifs';
        }

//        dd($menu);
        $can = true;
        $user = false;
        try {
            $user = Auth::user();
        } catch (Throwable $e) {

        }
//        Si la route a une permission et q'aucun user nest connecter
        if (!empty($menu->permission) && !$user) {
            $can = false;
        }
        if (
            !empty($menu->permission)
            && $user
            && !self::can($menu->permission)
        ) {
            $can = false;
        }
        if (self::justSuMenu($menu) && !empty($user) && $user->type_id != 4) {
            $can = false;
        }
        if (!empty($user) && $user->type_id == 4) {
            $can = true;
        }
        $actualEntreprise = self::getAppName();
        $actualEntreprise = Str::replace('.', '', $actualEntreprise);
        $actualEntreprise = Str::lower($actualEntreprise);


        if (!empty($menu->module) && !in_array($menu->module, $modules)) {
            $can = false;
        }
        if (!empty($menu->slug) && $menu->slug == 'Entreprises_web_index' && $actualEntreprise != "gtech") {
            $can = false;
        }

        return $can;
    }

    public static function getAppName()
    {
        $host = request()->getHttpHost();

        // $name = "Trans'urb";
        $name = "SGS";
//        $name = "SOBRAGA";
        // $name = "C.A";
//       $name = "GTECH";
//         $name = "BGFI";
        $disk = Storage::build([
            'driver' => 'local',
            'root' => base_path(),
        ]);
        $allFiles = collect($disk->allFiles("/Params"));
        foreach ($allFiles as $file) {
            $file = Str::replace('Params/', '', $file);
            $domain = Str::replace('_db.json', '', $file);
            if (Str::is($domain . '*', $host)) {
                $name = Str::upper($domain);
            }
        }

        return $name;


    }

    public static function can($permission)
    {
        $permission = trim($permission);
        $tableConcerner = explode(' ', $permission);
        $tableConcerner = $tableConcerner[count($tableConcerner) - 1];
        $type = false;
        if (Str::is('creer des *', Str::lower($permission))) {
            $type = 'canCreate';
        }
        if (Str::is('editer des *', Str::lower($permission))) {
            $type = 'canUpdate';
        }
        if (Str::is('supprimer des *', Str::lower($permission))) {
            $type = 'canDelete';
        }


        $can = false;
        $user = false;
        $user = Auth::user();
        $can = DB::table('model_has_permissions')
                ->join('permissions', 'model_has_permissions.permission_id', 'permissions.id')
                ->where('permissions.name', $permission)
                ->where('model_has_permissions.model_id', $user->id)
                ->count() > 0;
        $can2 = DB::table('role_has_permissions')
                ->join('permissions', 'role_has_permissions.permission_id', 'permissions.id')
                ->join('users', 'users.role_id', 'role_has_permissions.role_id')
                ->where([
                    'users.id' => $user->id,
                    'permissions.name' => $permission
                ])
                ->count() > 0;

        $can3 = false;
        if (!empty($type) && !empty($tableConcerner)) {
            $can3 = DB::table('role_has_permissions')
                    ->join('permissions', 'role_has_permissions.permission_id', 'permissions.id')
                    ->join('users', 'users.role_id', 'role_has_permissions.role_id')
                    ->where([
                        'users.id' => $user->id,
                        'permissions.name' => $tableConcerner,
                        $type => 'oui'
                    ])
                    ->count() > 0;
        }

        $can = $can + $can2 + $can3;

        if ($user->type_id == 4) {
            $can = true;
        }
//        dump($can,$can2,$can3,$user->id,$permission);
        return $can;
    }

    public static function justSuMenu($menu)
    {
        $can = false;
        if (!empty($menu->isSu)) {
            $can = true;
        }
        return $can;
    }

    public static function myMenu($menus)
    {

//        dd($menu);
        $can = true;
        $user = false;
        try {
            $user = Auth::user();
        } catch (Throwable $e) {

        }
        $menus = collect($menus)->filter(function ($data) use ($user) {
            $can = true;
            if (!empty($menu->permission) && !$user) {
                $can = false;
            }
            if (
                !empty($menu->permission)
                && $user
                && !self::can($menu->permission)
            ) {
                $can = false;
            }
            if (!empty($menu->isSu) && !empty($user) && $user->type_id != 4) {
                $can = false;
            }
            return $can;
        });


        return $menus->toArray();
    }

    public static function hideMenu($menu)
    {
        $can = false;
        $user = false;
        try {
            $user = Auth::user();
        } catch (Throwable $e) {
        }
        if (
            (!empty($menu->isSu) && empty($user)) ||
            (!empty($menu->isSu) && !empty($user) && $user->type_id != 4)
        ) {
            $can = true;
        }
        return $can;
    }

    public static function veroullerMenu($menu)
    {
//        dd($menu);
        $can = false;
        $user = false;
        try {
            $user = Auth::user();
        } catch (Throwable $e) {
        }
        if (
            (!empty($menu->permission) && empty($user)) ||
            (!empty($menu->permission) && !empty($user) && !self::can($menu->permission))
        ) {
            $can = true;
        }
        if (!empty($user) && $user->type_id == 4) {
            $can = false;
        }
        return $can;

    }

    public static function verifiePerms($perms)
    {

    }

    public static function getMenuLink($menu)
    {

        $url = 'javascript:void(0)';
        if (!empty($menu->url)) {
            $url = url($menu->url);
        }
        if (!empty($menu->slug)) {

            try {
                $url = URL::signedRoute($menu->slug);
            } catch (Throwable $e) {
            }
        }
        if (!Str::is('*127.0.0.1*', $url)) {
            $url = Str::replace('http://', 'https://', $url);
        }
        return $url;
    }

    public static function getHomeLinks()
    {
        $url = URL::signedRoute('HOMES_web_index');
        if (!Str::is('*127.0.0.1*', $url)) {
            $url = Str::replace('http://', 'https://', $url);
        }
        return $url;
    }

    public static function personalToken()
    {
        $personalToken = Session::get('personalToken');
        if (empty($personalToken)) {
            try {
                $user = Auth::user();
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->save();
                $personalToken = $tokenResult->accessToken;
            } catch (Throwable $e) {

            }
            Session::put('personalToken', $personalToken);
        }
        return $personalToken;

    }

    public static function getLogoName()
    {
        $name = self::getAppName();
        $name = strtolower($name);

        return asset('/logo/' . $name . '.supervizr.png');


    }

    public static function getFaviconName()
    {
        $name = self::getAppName();
        $name = strtolower($name);

        return asset('/logo/' . $name . '.supervizr.ico');


    }

    public static function getMenuName()
    {
        $name = self::getAppName();
        $name = strtolower($name);

        return $name;


    }

    public static function getLogoutRoute()
    {

        $url = URL::signedRoute('LOGOUT_web_index');

        if (!Str::is('*127.0.0.1*', $url)) {
            $url = Str::replace('http://', 'https://', $url);
        }
        return $url;


    }

    public static function horaire($pro, $id, $date)
    {
        $programmes = $pro->filter(function ($data) use ($date, $id) {
            // return $data->programmationsusers->pluck('user_id') ===  $id && $data->AllDatesInRange === $date;
            return $data->programmationsusers->pluck('user_id')->contains($id) && $data->AllDatesInRange->contains($date);
        });
        return $programmes;
    }

    public static function usersImportStats($table1, $table2)
    {
        $doublon = DB::table('users')
            ->leftJoin('users as users2', 'users.matricule', '=', 'users2.matricule')
            ->whereRaw('users.id != users2.id AND users.type_id =2 AND users.actif_id=1 AND users.deleted_at is null')
            ->pluck("users.matricule")->toArray();
        $doublon = array_unique($doublon);
        $Modifier = DB::table($table1)
            ->leftJoin($table2, "$table1.matricule", '=', "$table2.matricule")
            ->select("$table2.*")
            ->whereNotNull("$table1.matricule")
            ->where("$table1.type_id", "=", '2')
            ->whereRaw("$table1.nom != $table2.nom OR $table1.prenom != $table2.prenom OR $table1.num_badge != $table2.num_badge OR $table1.date_naissance != $table2.date_naissance OR $table1.num_cnss != $table2.num_cnss OR $table1.num_cnamgs != $table2.num_cnamgs OR $table1.date_embauche != $table2.date_embauche OR $table1.nationalite_id != $table2.nationalite_id OR $table1.direction_id != $table2.direction_id OR $table1.fonction_id != $table2.fonction_id");

        $Ajouter = DB::table($table2)
            ->select("$table2.*")
            ->where("$table2.type_id", "=", '2')
            ->whereNotNull("$table2.matricule")
            ->leftJoin($table1, "$table2.matricule", '=', "$table1.matricule")
            ->whereNull("$table1.matricule");

        $Retirer = DB::table($table1)
            ->select("$table1.*")
            ->whereNotNull("$table1.matricule")
            ->where("$table1.type_id", "=", '2')
            ->leftJoin($table2, "$table1.matricule", '=', "$table2.matricule")
            ->whereNull("$table2.matricule")->whereNull("$table2.matricule");

        return [
            'Delete' => $Retirer->count(),
            'Create' => $Ajouter->count(),
            'Update' => $Modifier->count(),
            'DeleteQuery' => $Retirer,
            'CreateQuery' => $Ajouter,
            'UpdateQuery' => $Modifier,
        ];
    }

//    Fonction qui me permet de switcher mon environement

    public static function setGlobalDbInstanceEnv()
    {
        // Just get access to the config.
        $config = App::make('config');
        $connections = $config->get('database.connections');
        \Illuminate\Support\Facades\Config::set('database.default', Helpers::getDBConnectionName());
    }

    public static function getDBConnectionName($name = '')
    {
        if (empty($name)) {
            $name = self::getAppName();
        }
        $name = strtoupper($name);
        $name = Str::replace('.', '', $name);

        return $name . '_DB_CONNECTION';


    }

    public static function autoMigrateDomains()
    {


//        on lance  les migrations sur tous les domaines qui existe deja
        $disk = Storage::build([
            'driver' => 'local',
            'root' => base_path(),
        ]);
        $allFiles = collect($disk->allFiles("/Params"));
        $baseDeDonnees = [];
        foreach ($allFiles as $file) {

//            on creer la base de donnees si elle nexiste pas
            $fileName = explode('/', $file);
            $fileName = $fileName[count($fileName) - 1];
            $domaine = Str::replace('_db.json', '', $fileName);


            $_dbParams = [];
            try {
                $dbConnectionParams = file_get_contents(base_path($file));
                $dbConnectionParams = json_decode($dbConnectionParams, true);
                foreach ($dbConnectionParams as $key => $param) {
                    $_dbParams[$key] = $param;
                }
            } catch (\Throwable $e) {

            }
            if (!empty(Str::lower($domaine))) {
                $baseDeDonnees[Str::lower($domaine)] = $_dbParams;

            }

        }
        $baseDeDonnees['gtech'] = [
            "host" => env('DB_HOST'),
            "username" => env('DB_USERNAME'),
            "password" => env('DB_PASSWORD'),
        ];
        foreach ($baseDeDonnees as $domaine => $dbParams) {

//            on creer la base de donnees si elle nexiste pas
            $domaine = $domaine;
            $dbName = $domaine . '_backend';
            $dbName = Str::lower($dbName);
            $createDbQuery = 'CREATE DATABASE ' . $dbName . ';';
            try {
                DB::statement($createDbQuery);
            } catch (\Throwable $e) {

            }
//            on recupere linstance par defaut de la base de donnees

            // Just get access to the config.
            $config = App::make('config');
            // Will contain the array of connections that appear in our database config file.
            $connections = $config->get('database.connections');
            // This line pulls out the default connection by key (by default it's `mysql`)
            $defaultConnection = $connections[$config->get('database.default')];

//            on creer une nouvelle connextions

            $newConnection = $defaultConnection;
            // Override the database name.
            $newConnection['database'] = $dbName;

            try {

                foreach ($dbParams as $key => $param) {
                    $newConnection[$key] = $param;
                }
            } catch (\Throwable $e) {

            }
            $connections[Helpers::getDBConnectionName($domaine)] = $newConnection;
            \Illuminate\Support\Facades\Config::set('database.connections', $connections);
            try {
                Artisan::call('migrate', array('--database' => Helpers::getDBConnectionName($domaine)));
            } catch (\Throwable $e) {
            }
            try {
                Artisan::call('db:seed', array('--database' => Helpers::getDBConnectionName($domaine)));
            } catch (\Throwable $e) {
            }
        }
    }

}


