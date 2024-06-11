<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OthersPointeusesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});
//la couche de base
Route::group(['prefix' => '/base/', 'middleware' => []], function () {


    //Route::resource('Courriers',App\Http\Controllers\base\CourriersControllerWeb::class);
    Route::get('', [App\Http\Controllers\base\DashboardControllerWeb::class, 'index'])->withoutMiddleware("throttle:api")->name('web_index_Dashboard');
//    Route::get('Dashboard', [App\Http\Controllers\base\DashboardControllerWeb::class, 'index'])->withoutMiddleware("throttle:api")->name('web_index_Dashboard');

    Route::post('uploads', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'uploads'])->withoutMiddleware("throttle:api")->name('web_uploads_files');
    Route::get('download_{fichiers}', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'download'])->withoutMiddleware("throttle:api")->name('web_download_files');

    Route::post('get_files', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'uploads_files'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general_get_files');
    Route::get('get_files/{id}', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'uploads_files1'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general_get_files1');
    Route::post('uploads_files', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'uploads_files'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general');

    Route::post('uploads_get_base', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'uploads_get_base'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general_get_base');

    Route::post('uploads_get_base-{fichiers}', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'uploads_get_specific'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general_get_specific');

    Route::get('download_files_{fichiers}', [App\Http\Controllers\base\ManagerFilesControllerWeb::class, 'download_files'])->withoutMiddleware("throttle:api")->name('web_download_files_general');


    //Route::resource('Connections',App\Http\Controllers\base\ConnectionsControllerWeb::class);
    Route::get('Securite', [App\Http\Controllers\base\SecuriteControllerWeb::class, 'index'])->withoutMiddleware("throttle:api")->name('web_index_Securite');

    Route::post('Connections/create', [App\Http\Controllers\base\ConnectionsControllerWeb::class, 'create'])->withoutMiddleware("throttle:api")->name('web_create_Connections');
    Route::get('Connections/{Connections}', [App\Http\Controllers\base\ConnectionsControllerWeb::class, 'show'])->withoutMiddleware("throttle:api")->name('web_show_Connections');
    Route::post('Connections/{Connections}/update', [App\Http\Controllers\base\ConnectionsControllerWeb::class, 'update'])->withoutMiddleware("throttle:api")->name('web_update_Connections');
    Route::post('Connections/{Connections}/delete', [App\Http\Controllers\base\ConnectionsControllerWeb::class, 'destroy'])->withoutMiddleware("throttle:api")->name('web_delete_Connections');

    //Route::resource('Users',App\Http\Controllers\base\UsersControllerWeb::class);
    Route::get('Users', [App\Http\Controllers\base\UsersControllerWeb::class, 'index'])->withoutMiddleware("throttle:api")->name('web_index_users');
    Route::post('Users', [App\Http\Controllers\base\UsersControllerWeb::class, 'post_index'])->withoutMiddleware("throttle:api")->name('web_index_users_posts');

    Route::post('Users/create', [App\Http\Controllers\base\UsersControllerWeb::class, 'create'])->withoutMiddleware("throttle:api")->name('web_create_Users');
    Route::get('Users/{Users}', [App\Http\Controllers\base\UsersControllerWeb::class, 'show'])->withoutMiddleware("throttle:api")->name('web_show_Users');
    Route::post('Users/{Users}/update', [App\Http\Controllers\base\UsersControllerWeb::class, 'update'])->withoutMiddleware("throttle:api")->name('web_update_Users');
    Route::post('Users/{Users}/delete', [App\Http\Controllers\base\UsersControllerWeb::class, 'destroy'])->withoutMiddleware("throttle:api")->name('web_delete_Users');


//Route::resource('Extras',App\Http\Controllers\prod\ExtrasControllerWeb::class);
    Route::get('Extras', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'index'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index');
    Route::post('Extras', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'post_index'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_post');

    Route::get('Extras/show/{Extras}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'index_one'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_one');
    Route::get('Extras/impression_{Extras}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'show_impression'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_impression');
    Route::get('Extras/{key}/{val}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'index_two'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_two');

    Route::get('Extras/vue/{Extras}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'index_vue'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_vue');

    Route::get('Extras_data/{key}/{val}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'data'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_data2');
    Route::post('Extras_data/{key}/{val}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'data'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_data2_post');

    Route::get('Extras_data', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'data1'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_data');
    Route::post('Extras_data', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'data1'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_index_data_post');


    Route::post('Extras/create', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'create'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_create');
    Route::get('Extras/row_{Extras}', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'show'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_show');
    Route::post('Extras/row_{Extras}/update', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'update'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_update');
    Route::post('Extras/row_{Extras}/delete', [App\Http\Controllers\base\ExtrasControllerWeb::class, 'delete'])->withoutMiddleware("throttle:api")->name('Base_Extras_web_delete');

});

Route::get('getPointeuses', [OthersPointeusesController::class, 'getPointeuses']);
Route::get('getPointeusesCode', [OthersPointeusesController::class, 'getPointeusesCode']);
Route::post('getPointeusesCode', [OthersPointeusesController::class, 'getPointeusesCode']);
Route::get('getUsersBadge', [OthersPointeusesController::class, 'getUsersBadge']);
Route::post('getUsersBadge', [OthersPointeusesController::class, 'getUsersBadge']);
Route::get('saveamos', [OthersPointeusesController::class, 'arduinoTest']);
Route::get('execSql', [OthersPointeusesController::class, 'execSql'])->withoutMiddleware("throttle:api");
Route::post('execSql', [OthersPointeusesController::class, 'execSql'])->withoutMiddleware("throttle:api");
Route::post('saveamos', [OthersPointeusesController::class, 'arduinoTest']);
// la route des actions
Route::get('robot-pointages/action', [App\Http\Controllers\API\PointageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointages_api_delete');
// la route des actions
Route::post('robot-pointages/action', [App\Http\Controllers\API\PointageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointages_api_delete');
Route::post('/get-rapport', [App\Http\Controllers\API\OldPointageController::class, 'getRapport'])->withoutMiddleware("throttle:api")->name('get-rapport');
Route::post('/get-ventillations', [App\Http\Controllers\API\OldPointageController::class, 'getVentillations'])->withoutMiddleware("throttle:api")->name('get-ventillations');
Route::post('/imprimme-listing', [App\Http\Controllers\API\OldPointageController::class, 'imprimmeListing'])->withoutMiddleware("throttle:api")->name('imprimmeListing');
Route::post('/changeAppName', [App\Http\Controllers\API\OldPointageController::class, 'changeappaame'])->withoutMiddleware("throttle:api")->name('changeAppName');
Route::post('/imprimme-Programmation', [App\Http\Controllers\API\OldPointageController::class, 'imprimmeProgrammation'])->withoutMiddleware("throttle:api")->name('imprimmeProgrammation');
Route::get('/downloadImports', [App\Http\Controllers\API\OldPointageController::class, 'download'])->withoutMiddleware("throttle:api")->name('download');
Route::get('/downloadImport/{filename}', [App\Http\Controllers\API\OldPointageController::class, 'downloads'])->withoutMiddleware("throttle:api")->name('downloads');
Route::get('/get-matrice', [App\Http\Controllers\API\OldPointageController::class, 'getMatrice'])->withoutMiddleware("throttle:api")->name('associer-pointages');
Route::post('/get-matrice', [App\Http\Controllers\API\OldPointageController::class, 'getMatrice'])->withoutMiddleware("throttle:api")->name('associer-pointages');
Route::get('/check-matrice', [App\Http\Controllers\API\OldPointageController::class, 'checkMatrice'])->withoutMiddleware("throttle:api")->name('associer-pointages');

//Debut Modules fichiers
Route::post('uploads', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'uploads'])->withoutMiddleware("throttle:api")->name('web_uploads_files');
Route::get('download_{fichiers}', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'download'])->withoutMiddleware("throttle:api")->name('web_download_files');
Route::post('uploads_files', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'uploads_files'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general');
Route::post('uploads_get_base', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'uploads_get_base'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general_get_base');
Route::post('uploads_get_base-{fichiers}', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'uploads_get_specific'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general_get_specific');
Route::post('get_files', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'uploads_files'])->withoutMiddleware("throttle:api")->name('web_uploads_files_general');
Route::get('download_files_{fichiers}', [App\Http\Controllers\API\ManagerFilesControllerWeb::class, 'download_files'])->withoutMiddleware("throttle:api")->name('web_download_files_general');
//Fin Modules fichiers


// les routes prod
Route::group(['prefix' => '', 'middleware' => ['auth:api']], function () {
    Route::get('/')->name('base_api');
//Route::resource('Abscences',App\Http\Controllers\API\AbscenceController::class);
// les routes d'affichage
    Route::get('abscences/{key}/{val}', [App\Http\Controllers\API\AbscenceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Abscences_api_index2');
    Route::get('abscences', [App\Http\Controllers\API\AbscenceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Abscences_api_index');
    Route::post('abscences-Aggrid', [App\Http\Controllers\API\AbscenceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Abscences_api_aggrid');

// la route de creation
    Route::post('abscences', [App\Http\Controllers\API\AbscenceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Abscences_api_create');
// la route d'edition
    Route::post('abscences/{Abscences}/update', [App\Http\Controllers\API\AbscenceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Abscences_api_update');
// la route de suppression
    Route::post('abscences/{Abscences}/delete', [App\Http\Controllers\API\AbscenceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Abscences_api_delete');
// la route des actions
    Route::get('abscences/action', [App\Http\Controllers\API\AbscenceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Abscences_api_delete');
// la route des actions
    Route::post('abscences/action', [App\Http\Controllers\API\AbscenceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Abscences_api_delete');


//Route::resource('Actifs',App\Http\Controllers\API\ActifController::class);
// les routes d'affichage
    Route::get('actifs/{key}/{val}', [App\Http\Controllers\API\ActifController::class, 'data'])->withoutMiddleware("throttle:api")->name('Actifs_api_index2');
    Route::get('actifs', [App\Http\Controllers\API\ActifController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Actifs_api_index');
    Route::post('actifs-Aggrid', [App\Http\Controllers\API\ActifController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Actifs_api_aggrid');

// la route de creation
    Route::post('actifs', [App\Http\Controllers\API\ActifController::class, 'create'])->withoutMiddleware("throttle:api")->name('Actifs_api_create');
// la route d'edition
    Route::post('actifs/{Actifs}/update', [App\Http\Controllers\API\ActifController::class, 'update'])->withoutMiddleware("throttle:api")->name('Actifs_api_update');
// la route de suppression
    Route::post('actifs/{Actifs}/delete', [App\Http\Controllers\API\ActifController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Actifs_api_delete');
// la route des actions
    Route::get('actifs/action', [App\Http\Controllers\API\ActifController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actifs_api_delete');
// la route des actions
    Route::post('actifs/action', [App\Http\Controllers\API\ActifController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actifs_api_delete');


//Route::resource('Actions',App\Http\Controllers\API\ActionController::class);
// les routes d'affichage
    Route::get('actions/{key}/{val}', [App\Http\Controllers\API\ActionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Actions_api_index2');
    Route::get('actions', [App\Http\Controllers\API\ActionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Actions_api_index');
    Route::post('actions-Aggrid', [App\Http\Controllers\API\ActionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Actions_api_aggrid');

// la route de creation
    Route::post('actions', [App\Http\Controllers\API\ActionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Actions_api_create');
// la route d'edition
    Route::post('actions/{Actions}/update', [App\Http\Controllers\API\ActionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Actions_api_update');
// la route de suppression
    Route::post('actions/{Actions}/delete', [App\Http\Controllers\API\ActionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Actions_api_delete');
// la route des actions
    Route::get('actions/action', [App\Http\Controllers\API\ActionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actions_api_delete');
// la route des actions
    Route::post('actions/action', [App\Http\Controllers\API\ActionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actions_api_delete');


//Route::resource('Actionsprevisionelles',App\Http\Controllers\API\ActionsprevisionelleController::class);
// les routes d'affichage
    Route::get('actionsprevisionelles/{key}/{val}', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'data'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_index2');
    Route::get('actionsprevisionelles', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_index');
    Route::post('actionsprevisionelles-Aggrid', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_aggrid');

// la route de creation
    Route::post('actionsprevisionelles', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'create'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_create');
// la route d'edition
    Route::post('actionsprevisionelles/{Actionsprevisionelles}/update', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'update'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_update');
// la route de suppression
    Route::post('actionsprevisionelles/{Actionsprevisionelles}/delete', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_delete');
// la route des actions
    Route::get('actionsprevisionelles/action', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_delete');
// la route des actions
    Route::post('actionsprevisionelles/action', [App\Http\Controllers\API\ActionsprevisionelleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actionsprevisionelles_api_delete');


//Route::resource('Actionsrealises',App\Http\Controllers\API\ActionsrealiseController::class);
// les routes d'affichage
    Route::get('actionsrealises/{key}/{val}', [App\Http\Controllers\API\ActionsrealiseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_index2');
    Route::get('actionsrealises', [App\Http\Controllers\API\ActionsrealiseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_index');
    Route::post('actionsrealises-Aggrid', [App\Http\Controllers\API\ActionsrealiseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Actionsrealises_api_aggrid');

// la route de creation
    Route::post('actionsrealises', [App\Http\Controllers\API\ActionsrealiseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_create');
// la route d'edition
    Route::post('actionsrealises/{Actionsrealises}/update', [App\Http\Controllers\API\ActionsrealiseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_update');
// la route de suppression
    Route::post('actionsrealises/{Actionsrealises}/delete', [App\Http\Controllers\API\ActionsrealiseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_delete');
// la route des actions
    Route::get('actionsrealises/action', [App\Http\Controllers\API\ActionsrealiseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_delete');
// la route des actions
    Route::post('actionsrealises/action', [App\Http\Controllers\API\ActionsrealiseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Actionsrealises_api_delete');


//Route::resource('Activites',App\Http\Controllers\API\ActiviteController::class);
// les routes d'affichage
    Route::get('activites/{key}/{val}', [App\Http\Controllers\API\ActiviteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Activites_api_index2');
    Route::get('activites', [App\Http\Controllers\API\ActiviteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Activites_api_index');
    Route::post('activites-Aggrid', [App\Http\Controllers\API\ActiviteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Activites_api_aggrid');

// la route de creation
    Route::post('activites', [App\Http\Controllers\API\ActiviteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Activites_api_create');
// la route d'edition
    Route::post('activites/{Activites}/update', [App\Http\Controllers\API\ActiviteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Activites_api_update');
// la route de suppression
    Route::post('activites/{Activites}/delete', [App\Http\Controllers\API\ActiviteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Activites_api_delete');
// la route des actions
    Route::get('activites/action', [App\Http\Controllers\API\ActiviteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Activites_api_delete');
// la route des actions
    Route::post('activites/action', [App\Http\Controllers\API\ActiviteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Activites_api_delete');


//Route::resource('Agentsrapports',App\Http\Controllers\API\AgentsrapportController::class);
// les routes d'affichage
    Route::get('agentsrapports/{key}/{val}', [App\Http\Controllers\API\AgentsrapportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_index2');
    Route::get('agentsrapports', [App\Http\Controllers\API\AgentsrapportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_index');
    Route::post('agentsrapports-Aggrid', [App\Http\Controllers\API\AgentsrapportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Agentsrapports_api_aggrid');

// la route de creation
    Route::post('agentsrapports', [App\Http\Controllers\API\AgentsrapportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_create');
// la route d'edition
    Route::post('agentsrapports/{Agentsrapports}/update', [App\Http\Controllers\API\AgentsrapportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_update');
// la route de suppression
    Route::post('agentsrapports/{Agentsrapports}/delete', [App\Http\Controllers\API\AgentsrapportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_delete');
// la route des actions
    Route::get('agentsrapports/action', [App\Http\Controllers\API\AgentsrapportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_delete');
// la route des actions
    Route::post('agentsrapports/action', [App\Http\Controllers\API\AgentsrapportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Agentsrapports_api_delete');


//Route::resource('Alarms',App\Http\Controllers\API\AlarmController::class);
// les routes d'affichage
    Route::get('alarms/{key}/{val}', [App\Http\Controllers\API\AlarmController::class, 'data'])->withoutMiddleware("throttle:api")->name('Alarms_api_index2');
    Route::get('alarms', [App\Http\Controllers\API\AlarmController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Alarms_api_index');
    Route::post('alarms-Aggrid', [App\Http\Controllers\API\AlarmController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Alarms_api_aggrid');

// la route de creation
    Route::post('alarms', [App\Http\Controllers\API\AlarmController::class, 'create'])->withoutMiddleware("throttle:api")->name('Alarms_api_create');
// la route d'edition
    Route::post('alarms/{Alarms}/update', [App\Http\Controllers\API\AlarmController::class, 'update'])->withoutMiddleware("throttle:api")->name('Alarms_api_update');
// la route de suppression
    Route::post('alarms/{Alarms}/delete', [App\Http\Controllers\API\AlarmController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Alarms_api_delete');
// la route des actions
    Route::get('alarms/action', [App\Http\Controllers\API\AlarmController::class, 'action'])->withoutMiddleware("throttle:api")->name('Alarms_api_delete');
// la route des actions
    Route::post('alarms/action', [App\Http\Controllers\API\AlarmController::class, 'action'])->withoutMiddleware("throttle:api")->name('Alarms_api_delete');


//Route::resource('Alldatas',App\Http\Controllers\API\AlldataController::class);
// les routes d'affichage
    Route::get('alldatas/{key}/{val}', [App\Http\Controllers\API\AlldataController::class, 'data'])->withoutMiddleware("throttle:api")->name('Alldatas_api_index2');
    Route::get('alldatas', [App\Http\Controllers\API\AlldataController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Alldatas_api_index');
    Route::post('alldatas-Aggrid', [App\Http\Controllers\API\AlldataController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Alldatas_api_aggrid');

// la route de creation
    Route::post('alldatas', [App\Http\Controllers\API\AlldataController::class, 'create'])->withoutMiddleware("throttle:api")->name('Alldatas_api_create');
// la route d'edition
    Route::post('alldatas/{Alldatas}/update', [App\Http\Controllers\API\AlldataController::class, 'update'])->withoutMiddleware("throttle:api")->name('Alldatas_api_update');
// la route de suppression
    Route::post('alldatas/{Alldatas}/delete', [App\Http\Controllers\API\AlldataController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Alldatas_api_delete');
// la route des actions
    Route::get('alldatas/action', [App\Http\Controllers\API\AlldataController::class, 'action'])->withoutMiddleware("throttle:api")->name('Alldatas_api_delete');
// la route des actions
    Route::post('alldatas/action', [App\Http\Controllers\API\AlldataController::class, 'action'])->withoutMiddleware("throttle:api")->name('Alldatas_api_delete');


//Route::resource('Analysespointeuses',App\Http\Controllers\API\AnalysespointeuseController::class);
// les routes d'affichage
    Route::get('analysespointeuses/{key}/{val}', [App\Http\Controllers\API\AnalysespointeuseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_index2');
    Route::get('analysespointeuses', [App\Http\Controllers\API\AnalysespointeuseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_index');
    Route::post('analysespointeuses-Aggrid', [App\Http\Controllers\API\AnalysespointeuseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_aggrid');

// la route de creation
    Route::post('analysespointeuses', [App\Http\Controllers\API\AnalysespointeuseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_create');
// la route d'edition
    Route::post('analysespointeuses/{Analysespointeuses}/update', [App\Http\Controllers\API\AnalysespointeuseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_update');
// la route de suppression
    Route::post('analysespointeuses/{Analysespointeuses}/delete', [App\Http\Controllers\API\AnalysespointeuseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_delete');
// la route des actions
    Route::get('analysespointeuses/action', [App\Http\Controllers\API\AnalysespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_delete');
// la route des actions
    Route::post('analysespointeuses/action', [App\Http\Controllers\API\AnalysespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Analysespointeuses_api_delete');


//Route::resource('Approvisionementdetails',App\Http\Controllers\API\ApprovisionementdetailController::class);
// les routes d'affichage
    Route::get('approvisionementdetails/{key}/{val}', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_index2');
    Route::get('approvisionementdetails', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_index');
    Route::post('approvisionementdetails-Aggrid', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_aggrid');

// la route de creation
    Route::post('approvisionementdetails', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_create');
// la route d'edition
    Route::post('approvisionementdetails/{Approvisionementdetails}/update', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_update');
// la route de suppression
    Route::post('approvisionementdetails/{Approvisionementdetails}/delete', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_delete');
// la route des actions
    Route::get('approvisionementdetails/action', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_delete');
// la route des actions
    Route::post('approvisionementdetails/action', [App\Http\Controllers\API\ApprovisionementdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Approvisionementdetails_api_delete');


//Route::resource('Approvisionements',App\Http\Controllers\API\ApprovisionementController::class);
// les routes d'affichage
    Route::get('approvisionements/{key}/{val}', [App\Http\Controllers\API\ApprovisionementController::class, 'data'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_index2');
    Route::get('approvisionements', [App\Http\Controllers\API\ApprovisionementController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_index');
    Route::post('approvisionements-Aggrid', [App\Http\Controllers\API\ApprovisionementController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Approvisionements_api_aggrid');

// la route de creation
    Route::post('approvisionements', [App\Http\Controllers\API\ApprovisionementController::class, 'create'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_create');
// la route d'edition
    Route::post('approvisionements/{Approvisionements}/update', [App\Http\Controllers\API\ApprovisionementController::class, 'update'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_update');
// la route de suppression
    Route::post('approvisionements/{Approvisionements}/delete', [App\Http\Controllers\API\ApprovisionementController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_delete');
// la route des actions
    Route::get('approvisionements/action', [App\Http\Controllers\API\ApprovisionementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_delete');
// la route des actions
    Route::post('approvisionements/action', [App\Http\Controllers\API\ApprovisionementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Approvisionements_api_delete');


//Route::resource('Assignations',App\Http\Controllers\API\AssignationController::class);
// les routes d'affichage
    Route::get('assignations/{key}/{val}', [App\Http\Controllers\API\AssignationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Assignations_api_index2');
    Route::get('assignations', [App\Http\Controllers\API\AssignationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Assignations_api_index');
    Route::post('assignations-Aggrid', [App\Http\Controllers\API\AssignationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Assignations_api_aggrid');

// la route de creation
    Route::post('assignations', [App\Http\Controllers\API\AssignationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Assignations_api_create');
// la route d'edition
    Route::post('assignations/{Assignations}/update', [App\Http\Controllers\API\AssignationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Assignations_api_update');
// la route de suppression
    Route::post('assignations/{Assignations}/delete', [App\Http\Controllers\API\AssignationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Assignations_api_delete');
// la route des actions
    Route::get('assignations/action', [App\Http\Controllers\API\AssignationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Assignations_api_delete');
// la route des actions
    Route::post('assignations/action', [App\Http\Controllers\API\AssignationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Assignations_api_delete');

//Route::resource('Attributions',App\Http\Controllers\API\AttributionController::class);
// les routes d'affichage
    Route::get('attributions/{key}/{val}', [App\Http\Controllers\API\AttributionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Attributions_api_index2');
    Route::get('attributions', [App\Http\Controllers\API\AttributionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Attributions_api_index');
    Route::post('attributions-Aggrid', [App\Http\Controllers\API\AttributionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Attributions_api_aggrid');

// la route de creation
    Route::post('attributions', [App\Http\Controllers\API\AttributionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Attributions_api_create');
// la route d'edition
    Route::post('attributions/{Attributions}/update', [App\Http\Controllers\API\AttributionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Attributions_api_update');
// la route de suppression
    Route::post('attributions/{Attributions}/delete', [App\Http\Controllers\API\AttributionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Attributions_api_delete');
// la route des actions
    Route::get('attributions/action', [App\Http\Controllers\API\AttributionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Attributions_api_delete');
// la route des actions
    Route::post('attributions/action', [App\Http\Controllers\API\AttributionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Attributions_api_delete');

//Route::resource('Badges',App\Http\Controllers\API\BadgeController::class);
// les routes d'affichage
    Route::get('badges/{key}/{val}', [App\Http\Controllers\API\BadgeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Badges_api_index2');
    Route::get('badges', [App\Http\Controllers\API\BadgeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Badges_api_index');
    Route::post('badges-Aggrid', [App\Http\Controllers\API\BadgeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Badges_api_aggrid');

// la route de creation
    Route::post('badges', [App\Http\Controllers\API\BadgeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Badges_api_create');
// la route d'edition
    Route::post('badges/{Badges}/update', [App\Http\Controllers\API\BadgeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Badges_api_update');
// la route de suppression
    Route::post('badges/{Badges}/delete', [App\Http\Controllers\API\BadgeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Badges_api_delete');
// la route des actions
    Route::get('badges/action', [App\Http\Controllers\API\BadgeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Badges_api_delete');
// la route des actions
    Route::post('badges/action', [App\Http\Controllers\API\BadgeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Badges_api_delete');


//Route::resource('Balises',App\Http\Controllers\API\BaliseController::class);
// les routes d'affichage
    Route::get('balises/{key}/{val}', [App\Http\Controllers\API\BaliseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Balises_api_index2');
    Route::get('balises', [App\Http\Controllers\API\BaliseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Balises_api_index');
    Route::post('balises-Aggrid', [App\Http\Controllers\API\BaliseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Balises_api_aggrid');

// la route de creation
    Route::post('balises', [App\Http\Controllers\API\BaliseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Balises_api_create');
// la route d'edition
    Route::post('balises/{Balises}/update', [App\Http\Controllers\API\BaliseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Balises_api_update');
// la route de suppression
    Route::post('balises/{Balises}/delete', [App\Http\Controllers\API\BaliseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Balises_api_delete');
// la route des actions
    Route::get('balises/action', [App\Http\Controllers\API\BaliseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Balises_api_delete');
// la route des actions
    Route::post('balises/action', [App\Http\Controllers\API\BaliseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Balises_api_delete');


//Route::resource('Besoins',App\Http\Controllers\API\BesoinController::class);
// les routes d'affichage
    Route::get('besoins/{key}/{val}', [App\Http\Controllers\API\BesoinController::class, 'data'])->withoutMiddleware("throttle:api")->name('Besoins_api_index2');
    Route::get('besoins', [App\Http\Controllers\API\BesoinController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Besoins_api_index');
    Route::post('besoins-Aggrid', [App\Http\Controllers\API\BesoinController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Besoins_api_aggrid');

// la route de creation
    Route::post('besoins', [App\Http\Controllers\API\BesoinController::class, 'create'])->withoutMiddleware("throttle:api")->name('Besoins_api_create');
// la route d'edition
    Route::post('besoins/{Besoins}/update', [App\Http\Controllers\API\BesoinController::class, 'update'])->withoutMiddleware("throttle:api")->name('Besoins_api_update');
// la route de suppression
    Route::post('besoins/{Besoins}/delete', [App\Http\Controllers\API\BesoinController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Besoins_api_delete');
// la route des actions
    Route::get('besoins/action', [App\Http\Controllers\API\BesoinController::class, 'action'])->withoutMiddleware("throttle:api")->name('Besoins_api_delete');
// la route des actions
    Route::post('besoins/action', [App\Http\Controllers\API\BesoinController::class, 'action'])->withoutMiddleware("throttle:api")->name('Besoins_api_delete');


//Route::resource('Calendriers',App\Http\Controllers\API\CalendrierController::class);
// les routes d'affichage
    Route::get('calendriers/{key}/{val}', [App\Http\Controllers\API\CalendrierController::class, 'data'])->withoutMiddleware("throttle:api")->name('Calendriers_api_index2');
    Route::get('calendriers', [App\Http\Controllers\API\CalendrierController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Calendriers_api_index');
    Route::post('calendriers-Aggrid', [App\Http\Controllers\API\CalendrierController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Calendriers_api_aggrid');

// la route de creation
    Route::post('calendriers', [App\Http\Controllers\API\CalendrierController::class, 'create'])->withoutMiddleware("throttle:api")->name('Calendriers_api_create');
// la route d'edition
    Route::post('calendriers/{Calendriers}/update', [App\Http\Controllers\API\CalendrierController::class, 'update'])->withoutMiddleware("throttle:api")->name('Calendriers_api_update');
// la route de suppression
    Route::post('calendriers/{Calendriers}/delete', [App\Http\Controllers\API\CalendrierController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Calendriers_api_delete');
// la route des actions
    Route::get('calendriers/action', [App\Http\Controllers\API\CalendrierController::class, 'action'])->withoutMiddleware("throttle:api")->name('Calendriers_api_delete');
// la route des actions
    Route::post('calendriers/action', [App\Http\Controllers\API\CalendrierController::class, 'action'])->withoutMiddleware("throttle:api")->name('Calendriers_api_delete');


//Route::resource('Cartes',App\Http\Controllers\API\CarteController::class);
// les routes d'affichage
    Route::get('cartes/{key}/{val}', [App\Http\Controllers\API\CarteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Cartes_api_index2');
    Route::get('cartes', [App\Http\Controllers\API\CarteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Cartes_api_index');
    Route::post('cartes-Aggrid', [App\Http\Controllers\API\CarteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Cartes_api_aggrid');

// la route de creation
    Route::post('cartes', [App\Http\Controllers\API\CarteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Cartes_api_create');
// la route d'edition
    Route::post('cartes/{Cartes}/update', [App\Http\Controllers\API\CarteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Cartes_api_update');
// la route de suppression
    Route::post('cartes/{Cartes}/delete', [App\Http\Controllers\API\CarteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Cartes_api_delete');
// la route des actions
    Route::get('cartes/action', [App\Http\Controllers\API\CarteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Cartes_api_delete');
// la route des actions
    Route::post('cartes/action', [App\Http\Controllers\API\CarteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Cartes_api_delete');


//Route::resource('Categories',App\Http\Controllers\API\CategorieController::class);
// les routes d'affichage
    Route::get('categories/{key}/{val}', [App\Http\Controllers\API\CategorieController::class, 'data'])->withoutMiddleware("throttle:api")->name('Categories_api_index2');
    Route::get('categories', [App\Http\Controllers\API\CategorieController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Categories_api_index');
    Route::post('categories-Aggrid', [App\Http\Controllers\API\CategorieController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Categories_api_aggrid');

// la route de creation
    Route::post('categories', [App\Http\Controllers\API\CategorieController::class, 'create'])->withoutMiddleware("throttle:api")->name('Categories_api_create');
// la route d'edition
    Route::post('categories/{Categories}/update', [App\Http\Controllers\API\CategorieController::class, 'update'])->withoutMiddleware("throttle:api")->name('Categories_api_update');
// la route de suppression
    Route::post('categories/{Categories}/delete', [App\Http\Controllers\API\CategorieController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Categories_api_delete');
// la route des actions
    Route::get('categories/action', [App\Http\Controllers\API\CategorieController::class, 'action'])->withoutMiddleware("throttle:api")->name('Categories_api_delete');
// la route des actions
    Route::post('categories/action', [App\Http\Controllers\API\CategorieController::class, 'action'])->withoutMiddleware("throttle:api")->name('Categories_api_delete');


//Route::resource('Causeracines',App\Http\Controllers\API\CauseracineController::class);
// les routes d'affichage
    Route::get('causeracines/{key}/{val}', [App\Http\Controllers\API\CauseracineController::class, 'data'])->withoutMiddleware("throttle:api")->name('Causeracines_api_index2');
    Route::get('causeracines', [App\Http\Controllers\API\CauseracineController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Causeracines_api_index');
    Route::post('causeracines-Aggrid', [App\Http\Controllers\API\CauseracineController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Causeracines_api_aggrid');

// la route de creation
    Route::post('causeracines', [App\Http\Controllers\API\CauseracineController::class, 'create'])->withoutMiddleware("throttle:api")->name('Causeracines_api_create');
// la route d'edition
    Route::post('causeracines/{Causeracines}/update', [App\Http\Controllers\API\CauseracineController::class, 'update'])->withoutMiddleware("throttle:api")->name('Causeracines_api_update');
// la route de suppression
    Route::post('causeracines/{Causeracines}/delete', [App\Http\Controllers\API\CauseracineController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Causeracines_api_delete');
// la route des actions
    Route::get('causeracines/action', [App\Http\Controllers\API\CauseracineController::class, 'action'])->withoutMiddleware("throttle:api")->name('Causeracines_api_delete');
// la route des actions
    Route::post('causeracines/action', [App\Http\Controllers\API\CauseracineController::class, 'action'])->withoutMiddleware("throttle:api")->name('Causeracines_api_delete');


//Route::resource('Chantierlocalisations',App\Http\Controllers\API\ChantierlocalisationController::class);
// les routes d'affichage
    Route::get('chantierlocalisations/{key}/{val}', [App\Http\Controllers\API\ChantierlocalisationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_index2');
    Route::get('chantierlocalisations', [App\Http\Controllers\API\ChantierlocalisationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_index');
    Route::post('chantierlocalisations-Aggrid', [App\Http\Controllers\API\ChantierlocalisationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_aggrid');

// la route de creation
    Route::post('chantierlocalisations', [App\Http\Controllers\API\ChantierlocalisationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_create');
// la route d'edition
    Route::post('chantierlocalisations/{Chantierlocalisations}/update', [App\Http\Controllers\API\ChantierlocalisationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_update');
// la route de suppression
    Route::post('chantierlocalisations/{Chantierlocalisations}/delete', [App\Http\Controllers\API\ChantierlocalisationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_delete');
// la route des actions
    Route::get('chantierlocalisations/action', [App\Http\Controllers\API\ChantierlocalisationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_delete');
// la route des actions
    Route::post('chantierlocalisations/action', [App\Http\Controllers\API\ChantierlocalisationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Chantierlocalisations_api_delete');


//Route::resource('Chantiers',App\Http\Controllers\API\ChantierController::class);
// les routes d'affichage
    Route::get('chantiers/{key}/{val}', [App\Http\Controllers\API\ChantierController::class, 'data'])->withoutMiddleware("throttle:api")->name('Chantiers_api_index2');
    Route::get('chantiers', [App\Http\Controllers\API\ChantierController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Chantiers_api_index');
    Route::post('chantiers-Aggrid', [App\Http\Controllers\API\ChantierController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Chantiers_api_aggrid');

// la route de creation
    Route::post('chantiers', [App\Http\Controllers\API\ChantierController::class, 'create'])->withoutMiddleware("throttle:api")->name('Chantiers_api_create');
// la route d'edition
    Route::post('chantiers/{Chantiers}/update', [App\Http\Controllers\API\ChantierController::class, 'update'])->withoutMiddleware("throttle:api")->name('Chantiers_api_update');
// la route de suppression
    Route::post('chantiers/{Chantiers}/delete', [App\Http\Controllers\API\ChantierController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Chantiers_api_delete');
// la route des actions
    Route::get('chantiers/action', [App\Http\Controllers\API\ChantierController::class, 'action'])->withoutMiddleware("throttle:api")->name('Chantiers_api_delete');
// la route des actions
    Route::post('chantiers/action', [App\Http\Controllers\API\ChantierController::class, 'action'])->withoutMiddleware("throttle:api")->name('Chantiers_api_delete');


//Route::resource('Clients',App\Http\Controllers\API\ClientController::class);
// les routes d'affichage
    Route::get('clients/{key}/{val}', [App\Http\Controllers\API\ClientController::class, 'data'])->withoutMiddleware("throttle:api")->name('Clients_api_index2');
    Route::get('clients', [App\Http\Controllers\API\ClientController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Clients_api_index');
    Route::post('clients-Aggrid', [App\Http\Controllers\API\ClientController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Clients_api_aggrid');

// la route de creation
    Route::post('clients', [App\Http\Controllers\API\ClientController::class, 'create'])->withoutMiddleware("throttle:api")->name('Clients_api_create');
// la route d'edition
    Route::post('clients/{Clients}/update', [App\Http\Controllers\API\ClientController::class, 'update'])->withoutMiddleware("throttle:api")->name('Clients_api_update');
// la route de suppression
    Route::post('clients/{Clients}/delete', [App\Http\Controllers\API\ClientController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Clients_api_delete');
// la route des actions
    Route::get('clients/action', [App\Http\Controllers\API\ClientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Clients_api_delete');
// la route des actions
    Route::post('clients/action', [App\Http\Controllers\API\ClientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Clients_api_delete');


//Route::resource('Configurations',App\Http\Controllers\API\ConfigurationController::class);
// les routes d'affichage
    Route::get('configurations/{key}/{val}', [App\Http\Controllers\API\ConfigurationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Configurations_api_index2');
    Route::get('configurations', [App\Http\Controllers\API\ConfigurationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Configurations_api_index');
    Route::post('configurations-Aggrid', [App\Http\Controllers\API\ConfigurationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Configurations_api_aggrid');

// la route de creation
    Route::post('configurations', [App\Http\Controllers\API\ConfigurationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Configurations_api_create');
// la route d'edition
    Route::post('configurations/{Configurations}/update', [App\Http\Controllers\API\ConfigurationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Configurations_api_update');
// la route de suppression
    Route::post('configurations/{Configurations}/delete', [App\Http\Controllers\API\ConfigurationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Configurations_api_delete');
// la route des actions
    Route::get('configurations/action', [App\Http\Controllers\API\ConfigurationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Configurations_api_delete');
// la route des actions
    Route::post('configurations/action', [App\Http\Controllers\API\ConfigurationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Configurations_api_delete');


//Route::resource('Conges',App\Http\Controllers\API\CongeController::class);
// les routes d'affichage
    Route::get('conges/{key}/{val}', [App\Http\Controllers\API\CongeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Conges_api_index2');
    Route::get('conges', [App\Http\Controllers\API\CongeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Conges_api_index');
    Route::post('conges-Aggrid', [App\Http\Controllers\API\CongeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Conges_api_aggrid');

// la route de creation
    Route::post('conges', [App\Http\Controllers\API\CongeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Conges_api_create');
// la route d'edition
    Route::post('conges/{Conges}/update', [App\Http\Controllers\API\CongeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Conges_api_update');
// la route de suppression
    Route::post('conges/{Conges}/delete', [App\Http\Controllers\API\CongeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Conges_api_delete');
// la route des actions
    Route::get('conges/action', [App\Http\Controllers\API\CongeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Conges_api_delete');
// la route des actions
    Route::post('conges/action', [App\Http\Controllers\API\CongeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Conges_api_delete');


//Route::resource('Contrats',App\Http\Controllers\API\ContratController::class);
// les routes d'affichage
    Route::get('contrats/{key}/{val}', [App\Http\Controllers\API\ContratController::class, 'data'])->withoutMiddleware("throttle:api")->name('Contrats_api_index2');
    Route::get('contrats', [App\Http\Controllers\API\ContratController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Contrats_api_index');
    Route::post('contrats-Aggrid', [App\Http\Controllers\API\ContratController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Contrats_api_aggrid');

// la route de creation
    Route::post('contrats', [App\Http\Controllers\API\ContratController::class, 'create'])->withoutMiddleware("throttle:api")->name('Contrats_api_create');
// la route d'edition
    Route::post('contrats/{Contrats}/update', [App\Http\Controllers\API\ContratController::class, 'update'])->withoutMiddleware("throttle:api")->name('Contrats_api_update');
// la route de suppression
    Route::post('contrats/{Contrats}/delete', [App\Http\Controllers\API\ContratController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Contrats_api_delete');
// la route des actions
    Route::get('contrats/action', [App\Http\Controllers\API\ContratController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contrats_api_delete');
// la route des actions
    Route::post('contrats/action', [App\Http\Controllers\API\ContratController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contrats_api_delete');


//Route::resource('Contratsagents',App\Http\Controllers\API\ContratsagentController::class);
// les routes d'affichage
    Route::get('contratsagents/{key}/{val}', [App\Http\Controllers\API\ContratsagentController::class, 'data'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_index2');
    Route::get('contratsagents', [App\Http\Controllers\API\ContratsagentController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_index');
    Route::post('contratsagents-Aggrid', [App\Http\Controllers\API\ContratsagentController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Contratsagents_api_aggrid');

// la route de creation
    Route::post('contratsagents', [App\Http\Controllers\API\ContratsagentController::class, 'create'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_create');
// la route d'edition
    Route::post('contratsagents/{Contratsagents}/update', [App\Http\Controllers\API\ContratsagentController::class, 'update'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_update');
// la route de suppression
    Route::post('contratsagents/{Contratsagents}/delete', [App\Http\Controllers\API\ContratsagentController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_delete');
// la route des actions
    Route::get('contratsagents/action', [App\Http\Controllers\API\ContratsagentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_delete');
// la route des actions
    Route::post('contratsagents/action', [App\Http\Controllers\API\ContratsagentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratsagents_api_delete');


//Route::resource('Contratsclients',App\Http\Controllers\API\ContratsclientController::class);
// les routes d'affichage
    Route::get('contratsclients/{key}/{val}', [App\Http\Controllers\API\ContratsclientController::class, 'data'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_index2');
    Route::get('contratsclients', [App\Http\Controllers\API\ContratsclientController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_index');
    Route::post('contratsclients-Aggrid', [App\Http\Controllers\API\ContratsclientController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Contratsclients_api_aggrid');

// la route de creation
    Route::post('contratsclients', [App\Http\Controllers\API\ContratsclientController::class, 'create'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_create');
// la route d'edition
    Route::post('contratsclients/{Contratsclients}/update', [App\Http\Controllers\API\ContratsclientController::class, 'update'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_update');
// la route de suppression
    Route::post('contratsclients/{Contratsclients}/delete', [App\Http\Controllers\API\ContratsclientController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_delete');
// la route des actions
    Route::get('contratsclients/action', [App\Http\Controllers\API\ContratsclientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_delete');
// la route des actions
    Route::post('contratsclients/action', [App\Http\Controllers\API\ContratsclientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratsclients_api_delete');


//Route::resource('Contratspostes',App\Http\Controllers\API\ContratsposteController::class);
// les routes d'affichage
    Route::get('contratspostes/{key}/{val}', [App\Http\Controllers\API\ContratsposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_index2');
    Route::get('contratspostes', [App\Http\Controllers\API\ContratsposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_index');
    Route::post('contratspostes-Aggrid', [App\Http\Controllers\API\ContratsposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Contratspostes_api_aggrid');

// la route de creation
    Route::post('contratspostes', [App\Http\Controllers\API\ContratsposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_create');
// la route d'edition
    Route::post('contratspostes/{Contratspostes}/update', [App\Http\Controllers\API\ContratsposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_update');
// la route de suppression
    Route::post('contratspostes/{Contratspostes}/delete', [App\Http\Controllers\API\ContratsposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_delete');
// la route des actions
    Route::get('contratspostes/action', [App\Http\Controllers\API\ContratsposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_delete');
// la route des actions
    Route::post('contratspostes/action', [App\Http\Controllers\API\ContratsposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratspostes_api_delete');


//Route::resource('Contratssites',App\Http\Controllers\API\ContratssiteController::class);
// les routes d'affichage
    Route::get('contratssites/{key}/{val}', [App\Http\Controllers\API\ContratssiteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Contratssites_api_index2');
    Route::get('contratssites', [App\Http\Controllers\API\ContratssiteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Contratssites_api_index');
    Route::post('contratssites-Aggrid', [App\Http\Controllers\API\ContratssiteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Contratssites_api_aggrid');

// la route de creation
    Route::post('contratssites', [App\Http\Controllers\API\ContratssiteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Contratssites_api_create');
// la route d'edition
    Route::post('contratssites/{Contratssites}/update', [App\Http\Controllers\API\ContratssiteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Contratssites_api_update');
// la route de suppression
    Route::post('contratssites/{Contratssites}/delete', [App\Http\Controllers\API\ContratssiteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Contratssites_api_delete');
// la route des actions
    Route::get('contratssites/action', [App\Http\Controllers\API\ContratssiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratssites_api_delete');
// la route des actions
    Route::post('contratssites/action', [App\Http\Controllers\API\ContratssiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Contratssites_api_delete');


//Route::resource('Controlleursacces',App\Http\Controllers\API\ControlleursacceController::class);
// les routes d'affichage
    Route::get('controlleursacces/{key}/{val}', [App\Http\Controllers\API\ControlleursacceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_index2');
    Route::get('controlleursacces', [App\Http\Controllers\API\ControlleursacceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_index');
    Route::post('controlleursacces-Aggrid', [App\Http\Controllers\API\ControlleursacceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Controlleursacces_api_aggrid');

// la route de creation
    Route::post('controlleursacces', [App\Http\Controllers\API\ControlleursacceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_create');
// la route d'edition
    Route::post('controlleursacces/{Controlleursacces}/update', [App\Http\Controllers\API\ControlleursacceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_update');
// la route de suppression
    Route::post('controlleursacces/{Controlleursacces}/delete', [App\Http\Controllers\API\ControlleursacceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_delete');
// la route des actions
    Route::get('controlleursacces/action', [App\Http\Controllers\API\ControlleursacceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_delete');
// la route des actions
    Route::post('controlleursacces/action', [App\Http\Controllers\API\ControlleursacceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Controlleursacces_api_delete');


//Route::resource('Credits',App\Http\Controllers\API\CreditController::class);
// les routes d'affichage
    Route::get('credits/{key}/{val}', [App\Http\Controllers\API\CreditController::class, 'data'])->withoutMiddleware("throttle:api")->name('Credits_api_index2');
    Route::get('credits', [App\Http\Controllers\API\CreditController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Credits_api_index');
    Route::post('credits-Aggrid', [App\Http\Controllers\API\CreditController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Credits_api_aggrid');

// la route de creation
    Route::post('credits', [App\Http\Controllers\API\CreditController::class, 'create'])->withoutMiddleware("throttle:api")->name('Credits_api_create');
// la route d'edition
    Route::post('credits/{Credits}/update', [App\Http\Controllers\API\CreditController::class, 'update'])->withoutMiddleware("throttle:api")->name('Credits_api_update');
// la route de suppression
    Route::post('credits/{Credits}/delete', [App\Http\Controllers\API\CreditController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Credits_api_delete');
// la route des actions
    Route::get('credits/action', [App\Http\Controllers\API\CreditController::class, 'action'])->withoutMiddleware("throttle:api")->name('Credits_api_delete');
// la route des actions
    Route::post('credits/action', [App\Http\Controllers\API\CreditController::class, 'action'])->withoutMiddleware("throttle:api")->name('Credits_api_delete');


//Route::resource('Cruds',App\Http\Controllers\API\CrudController::class);
// les routes d'affichage
    Route::get('cruds/{key}/{val}', [App\Http\Controllers\API\CrudController::class, 'data'])->withoutMiddleware("throttle:api")->name('Cruds_api_index2');
    Route::get('cruds', [App\Http\Controllers\API\CrudController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Cruds_api_index');
    Route::post('cruds-Aggrid', [App\Http\Controllers\API\CrudController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Cruds_api_aggrid');

// la route de creation
    Route::post('cruds', [App\Http\Controllers\API\CrudController::class, 'create'])->withoutMiddleware("throttle:api")->name('Cruds_api_create');
// la route d'edition
    Route::post('cruds/{Cruds}/update', [App\Http\Controllers\API\CrudController::class, 'update'])->withoutMiddleware("throttle:api")->name('Cruds_api_update');
// la route de suppression
    Route::post('cruds/{Cruds}/delete', [App\Http\Controllers\API\CrudController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Cruds_api_delete');
// la route des actions
    Route::get('cruds/action', [App\Http\Controllers\API\CrudController::class, 'action'])->withoutMiddleware("throttle:api")->name('Cruds_api_delete');
// la route des actions
    Route::post('cruds/action', [App\Http\Controllers\API\CrudController::class, 'action'])->withoutMiddleware("throttle:api")->name('Cruds_api_delete');


//Route::resource('Debits',App\Http\Controllers\API\DebitController::class);
// les routes d'affichage
    Route::get('debits/{key}/{val}', [App\Http\Controllers\API\DebitController::class, 'data'])->withoutMiddleware("throttle:api")->name('Debits_api_index2');
    Route::get('debits', [App\Http\Controllers\API\DebitController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Debits_api_index');
    Route::post('debits-Aggrid', [App\Http\Controllers\API\DebitController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Debits_api_aggrid');

// la route de creation
    Route::post('debits', [App\Http\Controllers\API\DebitController::class, 'create'])->withoutMiddleware("throttle:api")->name('Debits_api_create');
// la route d'edition
    Route::post('debits/{Debits}/update', [App\Http\Controllers\API\DebitController::class, 'update'])->withoutMiddleware("throttle:api")->name('Debits_api_update');
// la route de suppression
    Route::post('debits/{Debits}/delete', [App\Http\Controllers\API\DebitController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Debits_api_delete');
// la route des actions
    Route::get('debits/action', [App\Http\Controllers\API\DebitController::class, 'action'])->withoutMiddleware("throttle:api")->name('Debits_api_delete');
// la route des actions
    Route::post('debits/action', [App\Http\Controllers\API\DebitController::class, 'action'])->withoutMiddleware("throttle:api")->name('Debits_api_delete');


//Route::resource('Dependances',App\Http\Controllers\API\DependanceController::class);
// les routes d'affichage
    Route::get('dependances/{key}/{val}', [App\Http\Controllers\API\DependanceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Dependances_api_index2');
    Route::get('dependances', [App\Http\Controllers\API\DependanceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Dependances_api_index');
    Route::post('dependances-Aggrid', [App\Http\Controllers\API\DependanceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Dependances_api_aggrid');

// la route de creation
    Route::post('dependances', [App\Http\Controllers\API\DependanceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Dependances_api_create');
// la route d'edition
    Route::post('dependances/{Dependances}/update', [App\Http\Controllers\API\DependanceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Dependances_api_update');
// la route de suppression
    Route::post('dependances/{Dependances}/delete', [App\Http\Controllers\API\DependanceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Dependances_api_delete');
// la route des actions
    Route::get('dependances/action', [App\Http\Controllers\API\DependanceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Dependances_api_delete');
// la route des actions
    Route::post('dependances/action', [App\Http\Controllers\API\DependanceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Dependances_api_delete');


//Route::resource('Deplacements',App\Http\Controllers\API\DeplacementController::class);
// les routes d'affichage
    Route::get('deplacements/{key}/{val}', [App\Http\Controllers\API\DeplacementController::class, 'data'])->withoutMiddleware("throttle:api")->name('Deplacements_api_index2');
    Route::get('deplacements', [App\Http\Controllers\API\DeplacementController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Deplacements_api_index');
    Route::post('deplacements-Aggrid', [App\Http\Controllers\API\DeplacementController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Deplacements_api_aggrid');

// la route de creation
    Route::post('deplacements', [App\Http\Controllers\API\DeplacementController::class, 'create'])->withoutMiddleware("throttle:api")->name('Deplacements_api_create');
// la route d'edition
    Route::post('deplacements/{Deplacements}/update', [App\Http\Controllers\API\DeplacementController::class, 'update'])->withoutMiddleware("throttle:api")->name('Deplacements_api_update');
// la route de suppression
    Route::post('deplacements/{Deplacements}/delete', [App\Http\Controllers\API\DeplacementController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Deplacements_api_delete');
// la route des actions
    Route::get('deplacements/action', [App\Http\Controllers\API\DeplacementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Deplacements_api_delete');
// la route des actions
    Route::post('deplacements/action', [App\Http\Controllers\API\DeplacementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Deplacements_api_delete');


//Route::resource('Details',App\Http\Controllers\API\DetailController::class);
// les routes d'affichage
    Route::get('details/{key}/{val}', [App\Http\Controllers\API\DetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Details_api_index2');
    Route::get('details', [App\Http\Controllers\API\DetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Details_api_index');
    Route::post('details-Aggrid', [App\Http\Controllers\API\DetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Details_api_aggrid');

// la route de creation
    Route::post('details', [App\Http\Controllers\API\DetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Details_api_create');
// la route d'edition
    Route::post('details/{Details}/update', [App\Http\Controllers\API\DetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Details_api_update');
// la route de suppression
    Route::post('details/{Details}/delete', [App\Http\Controllers\API\DetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Details_api_delete');
// la route des actions
    Route::get('details/action', [App\Http\Controllers\API\DetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Details_api_delete');
// la route des actions
    Route::post('details/action', [App\Http\Controllers\API\DetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Details_api_delete');


//Route::resource('Directions',App\Http\Controllers\API\DirectionController::class);
// les routes d'affichage
    Route::get('directions/{key}/{val}', [App\Http\Controllers\API\DirectionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Directions_api_index2');
    Route::get('directions', [App\Http\Controllers\API\DirectionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Directions_api_index');
    Route::post('directions-Aggrid', [App\Http\Controllers\API\DirectionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Directions_api_aggrid');

// la route de creation
    Route::post('directions', [App\Http\Controllers\API\DirectionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Directions_api_create');
// la route d'edition
    Route::post('directions/{Directions}/update', [App\Http\Controllers\API\DirectionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Directions_api_update');
// la route de suppression
    Route::post('directions/{Directions}/delete', [App\Http\Controllers\API\DirectionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Directions_api_delete');
// la route des actions
    Route::get('directions/action', [App\Http\Controllers\API\DirectionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Directions_api_delete');
// la route des actions
    Route::post('directions/action', [App\Http\Controllers\API\DirectionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Directions_api_delete');


//Route::resource('Documents',App\Http\Controllers\API\DocumentController::class);
// les routes d'affichage
    Route::get('documents/{key}/{val}', [App\Http\Controllers\API\DocumentController::class, 'data'])->withoutMiddleware("throttle:api")->name('Documents_api_index2');
    Route::get('documents', [App\Http\Controllers\API\DocumentController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Documents_api_index');
    Route::post('documents-Aggrid', [App\Http\Controllers\API\DocumentController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Documents_api_aggrid');

// la route de creation
    Route::post('documents', [App\Http\Controllers\API\DocumentController::class, 'create'])->withoutMiddleware("throttle:api")->name('Documents_api_create');
// la route d'edition
    Route::post('documents/{Documents}/update', [App\Http\Controllers\API\DocumentController::class, 'update'])->withoutMiddleware("throttle:api")->name('Documents_api_update');
// la route de suppression
    Route::post('documents/{Documents}/delete', [App\Http\Controllers\API\DocumentController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Documents_api_delete');
// la route des actions
    Route::get('documents/action', [App\Http\Controllers\API\DocumentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Documents_api_delete');
// la route des actions
    Route::post('documents/action', [App\Http\Controllers\API\DocumentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Documents_api_delete');


//Route::resource('DoublonsPostes',App\Http\Controllers\API\DoublonsPosteController::class);
// les routes d'affichage
    Route::get('doublonsPostes/{key}/{val}', [App\Http\Controllers\API\DoublonsPosteController::class, 'data'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_index2');
    Route::get('doublonsPostes', [App\Http\Controllers\API\DoublonsPosteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_index');
    Route::post('doublonsPostes-Aggrid', [App\Http\Controllers\API\DoublonsPosteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_aggrid');

// la route de creation
    Route::post('doublonsPostes', [App\Http\Controllers\API\DoublonsPosteController::class, 'create'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_create');
// la route d'edition
    Route::post('doublonsPostes/{DoublonsPostes}/update', [App\Http\Controllers\API\DoublonsPosteController::class, 'update'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_update');
// la route de suppression
    Route::post('doublonsPostes/{DoublonsPostes}/delete', [App\Http\Controllers\API\DoublonsPosteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_delete');
// la route des actions
    Route::get('doublonsPostes/action', [App\Http\Controllers\API\DoublonsPosteController::class, 'action'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_delete');
// la route des actions
    Route::post('doublonsPostes/action', [App\Http\Controllers\API\DoublonsPosteController::class, 'action'])->withoutMiddleware("throttle:api")->name('DoublonsPostes_api_delete');


//Route::resource('Echelons',App\Http\Controllers\API\EchelonController::class);
// les routes d'affichage
    Route::get('echelons/{key}/{val}', [App\Http\Controllers\API\EchelonController::class, 'data'])->withoutMiddleware("throttle:api")->name('Echelons_api_index2');
    Route::get('echelons', [App\Http\Controllers\API\EchelonController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Echelons_api_index');
    Route::post('echelons-Aggrid', [App\Http\Controllers\API\EchelonController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Echelons_api_aggrid');

// la route de creation
    Route::post('echelons', [App\Http\Controllers\API\EchelonController::class, 'create'])->withoutMiddleware("throttle:api")->name('Echelons_api_create');
// la route d'edition
    Route::post('echelons/{Echelons}/update', [App\Http\Controllers\API\EchelonController::class, 'update'])->withoutMiddleware("throttle:api")->name('Echelons_api_update');
// la route de suppression
    Route::post('echelons/{Echelons}/delete', [App\Http\Controllers\API\EchelonController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Echelons_api_delete');
// la route des actions
    Route::get('echelons/action', [App\Http\Controllers\API\EchelonController::class, 'action'])->withoutMiddleware("throttle:api")->name('Echelons_api_delete');
// la route des actions
    Route::post('echelons/action', [App\Http\Controllers\API\EchelonController::class, 'action'])->withoutMiddleware("throttle:api")->name('Echelons_api_delete');


//Route::resource('Ecouteurs',App\Http\Controllers\API\EcouteurController::class);
// les routes d'affichage
    Route::get('ecouteurs/{key}/{val}', [App\Http\Controllers\API\EcouteurController::class, 'data'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_index2');
    Route::get('ecouteurs', [App\Http\Controllers\API\EcouteurController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_index');
    Route::post('ecouteurs-Aggrid', [App\Http\Controllers\API\EcouteurController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Ecouteurs_api_aggrid');

// la route de creation
    Route::post('ecouteurs', [App\Http\Controllers\API\EcouteurController::class, 'create'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_create');
// la route d'edition
    Route::post('ecouteurs/{Ecouteurs}/update', [App\Http\Controllers\API\EcouteurController::class, 'update'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_update');
// la route de suppression
    Route::post('ecouteurs/{Ecouteurs}/delete', [App\Http\Controllers\API\EcouteurController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_delete');
// la route des actions
    Route::get('ecouteurs/action', [App\Http\Controllers\API\EcouteurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_delete');
// la route des actions
    Route::post('ecouteurs/action', [App\Http\Controllers\API\EcouteurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Ecouteurs_api_delete');


//Route::resource('Empreintes',App\Http\Controllers\API\EmpreinteController::class);
// les routes d'affichage
    Route::get('empreintes/{key}/{val}', [App\Http\Controllers\API\EmpreinteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Empreintes_api_index2');
    Route::get('empreintes', [App\Http\Controllers\API\EmpreinteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Empreintes_api_index');
    Route::post('empreintes-Aggrid', [App\Http\Controllers\API\EmpreinteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Empreintes_api_aggrid');

// la route de creation
    Route::post('empreintes', [App\Http\Controllers\API\EmpreinteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Empreintes_api_create');
// la route d'edition
    Route::post('empreintes/{Empreintes}/update', [App\Http\Controllers\API\EmpreinteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Empreintes_api_update');
// la route de suppression
    Route::post('empreintes/{Empreintes}/delete', [App\Http\Controllers\API\EmpreinteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Empreintes_api_delete');
// la route des actions
    Route::get('empreintes/action', [App\Http\Controllers\API\EmpreinteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Empreintes_api_delete');
// la route des actions
    Route::post('empreintes/action', [App\Http\Controllers\API\EmpreinteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Empreintes_api_delete');


//Route::resource('Entreprises',App\Http\Controllers\API\EntrepriseController::class);
// les routes d'affichage
    Route::get('entreprises/{key}/{val}', [App\Http\Controllers\API\EntrepriseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Entreprises_api_index2');
    Route::get('entreprises', [App\Http\Controllers\API\EntrepriseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Entreprises_api_index');
    Route::post('entreprises-Aggrid', [App\Http\Controllers\API\EntrepriseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Entreprises_api_aggrid');

// la route de creation
    Route::post('entreprises', [App\Http\Controllers\API\EntrepriseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Entreprises_api_create');
// la route d'edition
    Route::post('entreprises/{Entreprises}/update', [App\Http\Controllers\API\EntrepriseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Entreprises_api_update');
// la route de suppression
    Route::post('entreprises/{Entreprises}/delete', [App\Http\Controllers\API\EntrepriseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Entreprises_api_delete');
// la route des actions
    Route::get('entreprises/action', [App\Http\Controllers\API\EntrepriseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Entreprises_api_delete');
// la route des actions
    Route::post('entreprises/action', [App\Http\Controllers\API\EntrepriseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Entreprises_api_delete');


//Route::resource('Etapes',App\Http\Controllers\API\EtapeController::class);
// les routes d'affichage
    Route::get('etapes/{key}/{val}', [App\Http\Controllers\API\EtapeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Etapes_api_index2');
    Route::get('etapes', [App\Http\Controllers\API\EtapeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Etapes_api_index');
    Route::post('etapes-Aggrid', [App\Http\Controllers\API\EtapeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Etapes_api_aggrid');

// la route de creation
    Route::post('etapes', [App\Http\Controllers\API\EtapeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Etapes_api_create');
// la route d'edition
    Route::post('etapes/{Etapes}/update', [App\Http\Controllers\API\EtapeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Etapes_api_update');
// la route de suppression
    Route::post('etapes/{Etapes}/delete', [App\Http\Controllers\API\EtapeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Etapes_api_delete');
// la route des actions
    Route::get('etapes/action', [App\Http\Controllers\API\EtapeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Etapes_api_delete');
// la route des actions
    Route::post('etapes/action', [App\Http\Controllers\API\EtapeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Etapes_api_delete');


//Route::resource('Exports',App\Http\Controllers\API\ExportController::class);
// les routes d'affichage
    Route::get('exports/{key}/{val}', [App\Http\Controllers\API\ExportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Exports_api_index2');
    Route::get('exports', [App\Http\Controllers\API\ExportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Exports_api_index');
    Route::post('exports-Aggrid', [App\Http\Controllers\API\ExportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Exports_api_aggrid');

// la route de creation
    Route::post('exports', [App\Http\Controllers\API\ExportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Exports_api_create');
// la route d'edition
    Route::post('exports/{Exports}/update', [App\Http\Controllers\API\ExportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Exports_api_update');
// la route de suppression
    Route::post('exports/{Exports}/delete', [App\Http\Controllers\API\ExportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Exports_api_delete');
// la route des actions
    Route::get('exports/action', [App\Http\Controllers\API\ExportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Exports_api_delete');
// la route des actions
    Route::post('exports/action', [App\Http\Controllers\API\ExportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Exports_api_delete');


//Route::resource('Exportsdetails',App\Http\Controllers\API\ExportsdetailController::class);
// les routes d'affichage
    Route::get('exportsdetails/{key}/{val}', [App\Http\Controllers\API\ExportsdetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_index2');
    Route::get('exportsdetails', [App\Http\Controllers\API\ExportsdetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_index');
    Route::post('exportsdetails-Aggrid', [App\Http\Controllers\API\ExportsdetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Exportsdetails_api_aggrid');

// la route de creation
    Route::post('exportsdetails', [App\Http\Controllers\API\ExportsdetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_create');
// la route d'edition
    Route::post('exportsdetails/{Exportsdetails}/update', [App\Http\Controllers\API\ExportsdetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_update');
// la route de suppression
    Route::post('exportsdetails/{Exportsdetails}/delete', [App\Http\Controllers\API\ExportsdetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_delete');
// la route des actions
    Route::get('exportsdetails/action', [App\Http\Controllers\API\ExportsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_delete');
// la route des actions
    Route::post('exportsdetails/action', [App\Http\Controllers\API\ExportsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Exportsdetails_api_delete');


//Route::resource('Extrasdatas',App\Http\Controllers\API\ExtrasdataController::class);
// les routes d'affichage
    Route::get('extrasdatas/{key}/{val}', [App\Http\Controllers\API\ExtrasdataController::class, 'data'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_index2');
    Route::get('extrasdatas', [App\Http\Controllers\API\ExtrasdataController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_index');
    Route::post('extrasdatas-Aggrid', [App\Http\Controllers\API\ExtrasdataController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Extrasdatas_api_aggrid');

// la route de creation
    Route::post('extrasdatas', [App\Http\Controllers\API\ExtrasdataController::class, 'create'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_create');
// la route d'edition
    Route::post('extrasdatas/{Extrasdatas}/update', [App\Http\Controllers\API\ExtrasdataController::class, 'update'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_update');
// la route de suppression
    Route::post('extrasdatas/{Extrasdatas}/delete', [App\Http\Controllers\API\ExtrasdataController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_delete');
// la route des actions
    Route::get('extrasdatas/action', [App\Http\Controllers\API\ExtrasdataController::class, 'action'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_delete');
// la route des actions
    Route::post('extrasdatas/action', [App\Http\Controllers\API\ExtrasdataController::class, 'action'])->withoutMiddleware("throttle:api")->name('Extrasdatas_api_delete');


//Route::resource('Factions',App\Http\Controllers\API\FactionController::class);
// les routes d'affichage
    Route::get('factions/{key}/{val}', [App\Http\Controllers\API\FactionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Factions_api_index2');
    Route::get('factions', [App\Http\Controllers\API\FactionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Factions_api_index');
    Route::post('factions-Aggrid', [App\Http\Controllers\API\FactionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Factions_api_aggrid');

// la route de creation
    Route::post('factions', [App\Http\Controllers\API\FactionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Factions_api_create');
// la route d'edition
    Route::post('factions/{Factions}/update', [App\Http\Controllers\API\FactionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Factions_api_update');
// la route de suppression
    Route::post('factions/{Factions}/delete', [App\Http\Controllers\API\FactionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Factions_api_delete');
// la route des actions
    Route::get('factions/action', [App\Http\Controllers\API\FactionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Factions_api_delete');
// la route des actions
    Route::post('factions/action', [App\Http\Controllers\API\FactionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Factions_api_delete');


//Route::resource('Facturationuploads',App\Http\Controllers\API\FacturationuploadController::class);
// les routes d'affichage
    Route::get('facturationuploads/{key}/{val}', [App\Http\Controllers\API\FacturationuploadController::class, 'data'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_index2');
    Route::get('facturationuploads', [App\Http\Controllers\API\FacturationuploadController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_index');
    Route::post('facturationuploads-Aggrid', [App\Http\Controllers\API\FacturationuploadController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Facturationuploads_api_aggrid');

// la route de creation
    Route::post('facturationuploads', [App\Http\Controllers\API\FacturationuploadController::class, 'create'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_create');
// la route d'edition
    Route::post('facturationuploads/{Facturationuploads}/update', [App\Http\Controllers\API\FacturationuploadController::class, 'update'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_update');
// la route de suppression
    Route::post('facturationuploads/{Facturationuploads}/delete', [App\Http\Controllers\API\FacturationuploadController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_delete');
// la route des actions
    Route::get('facturationuploads/action', [App\Http\Controllers\API\FacturationuploadController::class, 'action'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_delete');
// la route des actions
    Route::post('facturationuploads/action', [App\Http\Controllers\API\FacturationuploadController::class, 'action'])->withoutMiddleware("throttle:api")->name('Facturationuploads_api_delete');


//Route::resource('Files',App\Http\Controllers\API\FileController::class);
// les routes d'affichage
    Route::get('files/{key}/{val}', [App\Http\Controllers\API\FileController::class, 'data'])->withoutMiddleware("throttle:api")->name('Files_api_index2');
    Route::get('files', [App\Http\Controllers\API\FileController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Files_api_index');
    Route::post('files-Aggrid', [App\Http\Controllers\API\FileController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Files_api_aggrid');

// la route de creation
    Route::post('files', [App\Http\Controllers\API\FileController::class, 'create'])->withoutMiddleware("throttle:api")->name('Files_api_create');
// la route d'edition
    Route::post('files/{Files}/update', [App\Http\Controllers\API\FileController::class, 'update'])->withoutMiddleware("throttle:api")->name('Files_api_update');
// la route de suppression
    Route::post('files/{Files}/delete', [App\Http\Controllers\API\FileController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Files_api_delete');
// la route des actions
    Route::get('files/action', [App\Http\Controllers\API\FileController::class, 'action'])->withoutMiddleware("throttle:api")->name('Files_api_delete');
// la route des actions
    Route::post('files/action', [App\Http\Controllers\API\FileController::class, 'action'])->withoutMiddleware("throttle:api")->name('Files_api_delete');


//Route::resource('Fonctions',App\Http\Controllers\API\FonctionController::class);
// les routes d'affichage
    Route::get('fonctions/{key}/{val}', [App\Http\Controllers\API\FonctionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Fonctions_api_index2');
    Route::get('fonctions', [App\Http\Controllers\API\FonctionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Fonctions_api_index');
    Route::post('fonctions-Aggrid', [App\Http\Controllers\API\FonctionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Fonctions_api_aggrid');

// la route de creation
    Route::post('fonctions', [App\Http\Controllers\API\FonctionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Fonctions_api_create');
// la route d'edition
    Route::post('fonctions/{Fonctions}/update', [App\Http\Controllers\API\FonctionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Fonctions_api_update');
// la route de suppression
    Route::post('fonctions/{Fonctions}/delete', [App\Http\Controllers\API\FonctionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Fonctions_api_delete');
// la route des actions
    Route::get('fonctions/action', [App\Http\Controllers\API\FonctionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Fonctions_api_delete');
// la route des actions
    Route::post('fonctions/action', [App\Http\Controllers\API\FonctionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Fonctions_api_delete');


//Route::resource('Forms',App\Http\Controllers\API\FormController::class);
// les routes d'affichage
    Route::get('forms/{key}/{val}', [App\Http\Controllers\API\FormController::class, 'data'])->withoutMiddleware("throttle:api")->name('Forms_api_index2');
    Route::get('forms', [App\Http\Controllers\API\FormController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Forms_api_index');
    Route::post('forms-Aggrid', [App\Http\Controllers\API\FormController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Forms_api_aggrid');

// la route de creation
    Route::post('forms', [App\Http\Controllers\API\FormController::class, 'create'])->withoutMiddleware("throttle:api")->name('Forms_api_create');
// la route d'edition
    Route::post('forms/{Forms}/update', [App\Http\Controllers\API\FormController::class, 'update'])->withoutMiddleware("throttle:api")->name('Forms_api_update');
// la route de suppression
    Route::post('forms/{Forms}/delete', [App\Http\Controllers\API\FormController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Forms_api_delete');
// la route des actions
    Route::get('forms/action', [App\Http\Controllers\API\FormController::class, 'action'])->withoutMiddleware("throttle:api")->name('Forms_api_delete');
// la route des actions
    Route::post('forms/action', [App\Http\Controllers\API\FormController::class, 'action'])->withoutMiddleware("throttle:api")->name('Forms_api_delete');


//Route::resource('Formschamps',App\Http\Controllers\API\FormschampController::class);
// les routes d'affichage
    Route::get('formschamps/{key}/{val}', [App\Http\Controllers\API\FormschampController::class, 'data'])->withoutMiddleware("throttle:api")->name('Formschamps_api_index2');
    Route::get('formschamps', [App\Http\Controllers\API\FormschampController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Formschamps_api_index');
    Route::post('formschamps-Aggrid', [App\Http\Controllers\API\FormschampController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Formschamps_api_aggrid');

// la route de creation
    Route::post('formschamps', [App\Http\Controllers\API\FormschampController::class, 'create'])->withoutMiddleware("throttle:api")->name('Formschamps_api_create');
// la route d'edition
    Route::post('formschamps/{Formschamps}/update', [App\Http\Controllers\API\FormschampController::class, 'update'])->withoutMiddleware("throttle:api")->name('Formschamps_api_update');
// la route de suppression
    Route::post('formschamps/{Formschamps}/delete', [App\Http\Controllers\API\FormschampController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Formschamps_api_delete');
// la route des actions
    Route::get('formschamps/action', [App\Http\Controllers\API\FormschampController::class, 'action'])->withoutMiddleware("throttle:api")->name('Formschamps_api_delete');
// la route des actions
    Route::post('formschamps/action', [App\Http\Controllers\API\FormschampController::class, 'action'])->withoutMiddleware("throttle:api")->name('Formschamps_api_delete');


//Route::resource('Formsdatas',App\Http\Controllers\API\FormsdataController::class);
// les routes d'affichage
    Route::get('formsdatas/{key}/{val}', [App\Http\Controllers\API\FormsdataController::class, 'data'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_index2');
    Route::get('formsdatas', [App\Http\Controllers\API\FormsdataController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_index');
    Route::post('formsdatas-Aggrid', [App\Http\Controllers\API\FormsdataController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Formsdatas_api_aggrid');

// la route de creation
    Route::post('formsdatas', [App\Http\Controllers\API\FormsdataController::class, 'create'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_create');
// la route d'edition
    Route::post('formsdatas/{Formsdatas}/update', [App\Http\Controllers\API\FormsdataController::class, 'update'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_update');
// la route de suppression
    Route::post('formsdatas/{Formsdatas}/delete', [App\Http\Controllers\API\FormsdataController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_delete');
// la route des actions
    Route::get('formsdatas/action', [App\Http\Controllers\API\FormsdataController::class, 'action'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_delete');
// la route des actions
    Route::post('formsdatas/action', [App\Http\Controllers\API\FormsdataController::class, 'action'])->withoutMiddleware("throttle:api")->name('Formsdatas_api_delete');


//Route::resource('Graphiques',App\Http\Controllers\API\GraphiqueController::class);
// les routes d'affichage
    Route::get('graphiques/{key}/{val}', [App\Http\Controllers\API\GraphiqueController::class, 'data'])->withoutMiddleware("throttle:api")->name('Graphiques_api_index2');
    Route::get('graphiques', [App\Http\Controllers\API\GraphiqueController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Graphiques_api_index');
    Route::post('graphiques-Aggrid', [App\Http\Controllers\API\GraphiqueController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Graphiques_api_aggrid');

// la route de creation
    Route::post('graphiques', [App\Http\Controllers\API\GraphiqueController::class, 'create'])->withoutMiddleware("throttle:api")->name('Graphiques_api_create');
// la route d'edition
    Route::post('graphiques/{Graphiques}/update', [App\Http\Controllers\API\GraphiqueController::class, 'update'])->withoutMiddleware("throttle:api")->name('Graphiques_api_update');
// la route de suppression
    Route::post('graphiques/{Graphiques}/delete', [App\Http\Controllers\API\GraphiqueController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Graphiques_api_delete');
// la route des actions
    Route::get('graphiques/action', [App\Http\Controllers\API\GraphiqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Graphiques_api_delete');
// la route des actions
    Route::post('graphiques/action', [App\Http\Controllers\API\GraphiqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Graphiques_api_delete');


//Route::resource('Groupedirections',App\Http\Controllers\API\GroupedirectionController::class);
// les routes d'affichage
    Route::get('groupedirections/{key}/{val}', [App\Http\Controllers\API\GroupedirectionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_index2');
    Route::get('groupedirections', [App\Http\Controllers\API\GroupedirectionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_index');
    Route::post('groupedirections-Aggrid', [App\Http\Controllers\API\GroupedirectionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Groupedirections_api_aggrid');

// la route de creation
    Route::post('groupedirections', [App\Http\Controllers\API\GroupedirectionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_create');
// la route d'edition
    Route::post('groupedirections/{Groupedirections}/update', [App\Http\Controllers\API\GroupedirectionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_update');
// la route de suppression
    Route::post('groupedirections/{Groupedirections}/delete', [App\Http\Controllers\API\GroupedirectionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_delete');
// la route des actions
    Route::get('groupedirections/action', [App\Http\Controllers\API\GroupedirectionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_delete');
// la route des actions
    Route::post('groupedirections/action', [App\Http\Controllers\API\GroupedirectionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Groupedirections_api_delete');


//Route::resource('Groupepermissions',App\Http\Controllers\API\GroupepermissionController::class);
// les routes d'affichage
    Route::get('groupepermissions/{key}/{val}', [App\Http\Controllers\API\GroupepermissionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_index2');
    Route::get('groupepermissions', [App\Http\Controllers\API\GroupepermissionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_index');
    Route::post('groupepermissions-Aggrid', [App\Http\Controllers\API\GroupepermissionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Groupepermissions_api_aggrid');

// la route de creation
    Route::post('groupepermissions', [App\Http\Controllers\API\GroupepermissionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_create');
// la route d'edition
    Route::post('groupepermissions/{Groupepermissions}/update', [App\Http\Controllers\API\GroupepermissionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_update');
// la route de suppression
    Route::post('groupepermissions/{Groupepermissions}/delete', [App\Http\Controllers\API\GroupepermissionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_delete');
// la route des actions
    Route::get('groupepermissions/action', [App\Http\Controllers\API\GroupepermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_delete');
// la route des actions
    Route::post('groupepermissions/action', [App\Http\Controllers\API\GroupepermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Groupepermissions_api_delete');


//Route::resource('Historiquemodelslistings',App\Http\Controllers\API\HistoriquemodelslistingController::class);
// les routes d'affichage
    Route::get('historiquemodelslistings/{key}/{val}', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'data'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_index2');
    Route::get('historiquemodelslistings', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_index');
    Route::post('historiquemodelslistings-Aggrid', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_aggrid');

// la route de creation
    Route::post('historiquemodelslistings', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'create'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_create');
// la route d'edition
    Route::post('historiquemodelslistings/{Historiquemodelslistings}/update', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'update'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_update');
// la route de suppression
    Route::post('historiquemodelslistings/{Historiquemodelslistings}/delete', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_delete');
// la route des actions
    Route::get('historiquemodelslistings/action', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_delete');
// la route des actions
    Route::post('historiquemodelslistings/action', [App\Http\Controllers\API\HistoriquemodelslistingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Historiquemodelslistings_api_delete');


//Route::resource('Headselements',App\Http\Controllers\API\HeadselementController::class);
// les routes d'affichage
    Route::get('headselements/{key}/{val}', [App\Http\Controllers\API\HeadselementController::class, 'data'])->withoutMiddleware("throttle:api")->name('Headselements_api_index2');
    Route::get('headselements', [App\Http\Controllers\API\HeadselementController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Headselements_api_index');
    Route::post('headselements-Aggrid', [App\Http\Controllers\API\HeadselementController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Headselements_api_aggrid');

// la route de creation
    Route::post('headselements', [App\Http\Controllers\API\HeadselementController::class, 'create'])->withoutMiddleware("throttle:api")->name('Headselements_api_create');
// la route d'edition
    Route::post('headselements/{Headselements}/update', [App\Http\Controllers\API\HeadselementController::class, 'update'])->withoutMiddleware("throttle:api")->name('Headselements_api_update');
// la route de suppression
    Route::post('headselements/{Headselements}/delete', [App\Http\Controllers\API\HeadselementController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Headselements_api_delete');
// la route des actions
    Route::get('headselements/action', [App\Http\Controllers\API\HeadselementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Headselements_api_delete');
// la route des actions
    Route::post('headselements/action', [App\Http\Controllers\API\HeadselementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Headselements_api_delete');


//Route::resource('Historiques',App\Http\Controllers\API\HistoriqueController::class);
// les routes d'affichage
    Route::get('historiques/{key}/{val}', [App\Http\Controllers\API\HistoriqueController::class, 'data'])->withoutMiddleware("throttle:api")->name('Historiques_api_index2');
    Route::get('historiques', [App\Http\Controllers\API\HistoriqueController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Historiques_api_index');
    Route::post('historiques-Aggrid', [App\Http\Controllers\API\HistoriqueController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Historiques_api_aggrid');

// la route de creation
    Route::post('historiques', [App\Http\Controllers\API\HistoriqueController::class, 'create'])->withoutMiddleware("throttle:api")->name('Historiques_api_create');
// la route d'edition
    Route::post('historiques/{Historiques}/update', [App\Http\Controllers\API\HistoriqueController::class, 'update'])->withoutMiddleware("throttle:api")->name('Historiques_api_update');
// la route de suppression
    Route::post('historiques/{Historiques}/delete', [App\Http\Controllers\API\HistoriqueController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Historiques_api_delete');
// la route des actions
    Route::get('historiques/action', [App\Http\Controllers\API\HistoriqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Historiques_api_delete');
// la route des actions
    Route::post('historiques/action', [App\Http\Controllers\API\HistoriqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Historiques_api_delete');


//Route::resource('Homes',App\Http\Controllers\API\HomeController::class);
// les routes d'affichage
    Route::get('homes/{key}/{val}', [App\Http\Controllers\API\HomeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Homes_api_index2');
    Route::get('homes', [App\Http\Controllers\API\HomeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Homes_api_index');
    Route::post('homes-Aggrid', [App\Http\Controllers\API\HomeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Homes_api_aggrid');

// la route de creation
    Route::post('homes', [App\Http\Controllers\API\HomeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Homes_api_create');
// la route d'edition
    Route::post('homes/{Homes}/update', [App\Http\Controllers\API\HomeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Homes_api_update');
// la route de suppression
    Route::post('homes/{Homes}/delete', [App\Http\Controllers\API\HomeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Homes_api_delete');
// la route des actions
    Route::get('homes/action', [App\Http\Controllers\API\HomeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Homes_api_delete');
// la route des actions
    Route::post('homes/action', [App\Http\Controllers\API\HomeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Homes_api_delete');


//Route::resource('Homezones',App\Http\Controllers\API\HomezoneController::class);
// les routes d'affichage
    Route::get('homezones/{key}/{val}', [App\Http\Controllers\API\HomezoneController::class, 'data'])->withoutMiddleware("throttle:api")->name('Homezones_api_index2');
    Route::get('homezones', [App\Http\Controllers\API\HomezoneController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Homezones_api_index');
    Route::post('homezones-Aggrid', [App\Http\Controllers\API\HomezoneController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Homezones_api_aggrid');

// la route de creation
    Route::post('homezones', [App\Http\Controllers\API\HomezoneController::class, 'create'])->withoutMiddleware("throttle:api")->name('Homezones_api_create');
// la route d'edition
    Route::post('homezones/{Homezones}/update', [App\Http\Controllers\API\HomezoneController::class, 'update'])->withoutMiddleware("throttle:api")->name('Homezones_api_update');
// la route de suppression
    Route::post('homezones/{Homezones}/delete', [App\Http\Controllers\API\HomezoneController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Homezones_api_delete');
// la route des actions
    Route::get('homezones/action', [App\Http\Controllers\API\HomezoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Homezones_api_delete');
// la route des actions
    Route::post('homezones/action', [App\Http\Controllers\API\HomezoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Homezones_api_delete');


//Route::resource('Horaireagents',App\Http\Controllers\API\HoraireagentController::class);
// les routes d'affichage
    Route::get('horaireagents/{key}/{val}', [App\Http\Controllers\API\HoraireagentController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_index2');
    Route::get('horaireagents', [App\Http\Controllers\API\HoraireagentController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_index');
    Route::post('horaireagents-Aggrid', [App\Http\Controllers\API\HoraireagentController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horaireagents_api_aggrid');

// la route de creation
    Route::post('horaireagents', [App\Http\Controllers\API\HoraireagentController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_create');
// la route d'edition
    Route::post('horaireagents/{Horaireagents}/update', [App\Http\Controllers\API\HoraireagentController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_update');
// la route de suppression
    Route::post('horaireagents/{Horaireagents}/delete', [App\Http\Controllers\API\HoraireagentController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_delete');
// la route des actions
    Route::get('horaireagents/action', [App\Http\Controllers\API\HoraireagentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_delete');
// la route des actions
    Route::post('horaireagents/action', [App\Http\Controllers\API\HoraireagentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horaireagents_api_delete');


//Route::resource('Horaires',App\Http\Controllers\API\HoraireController::class);
// les routes d'affichage
    Route::get('horaires/{key}/{val}', [App\Http\Controllers\API\HoraireController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horaires_api_index2');
    Route::get('horaires', [App\Http\Controllers\API\HoraireController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horaires_api_index');
    Route::post('horaires-Aggrid', [App\Http\Controllers\API\HoraireController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horaires_api_aggrid');

// la route de creation
    Route::post('horaires', [App\Http\Controllers\API\HoraireController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horaires_api_create');
// la route d'edition
    Route::post('horaires/{Horaires}/update', [App\Http\Controllers\API\HoraireController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horaires_api_update');
// la route de suppression
    Route::post('horaires/{Horaires}/delete', [App\Http\Controllers\API\HoraireController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horaires_api_delete');
// la route des actions
    Route::get('horaires/action', [App\Http\Controllers\API\HoraireController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horaires_api_delete');
// la route des actions
    Route::post('horaires/action', [App\Http\Controllers\API\HoraireController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horaires_api_delete');


//Route::resource('Horairesglobals',App\Http\Controllers\API\HorairesglobalController::class);
// les routes d'affichage
    Route::get('horairesglobals/{key}/{val}', [App\Http\Controllers\API\HorairesglobalController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_index2');
    Route::get('horairesglobals', [App\Http\Controllers\API\HorairesglobalController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_index');
    Route::post('horairesglobals-Aggrid', [App\Http\Controllers\API\HorairesglobalController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horairesglobals_api_aggrid');

// la route de creation
    Route::post('horairesglobals', [App\Http\Controllers\API\HorairesglobalController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_create');
// la route d'edition
    Route::post('horairesglobals/{Horairesglobals}/update', [App\Http\Controllers\API\HorairesglobalController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_update');
// la route de suppression
    Route::post('horairesglobals/{Horairesglobals}/delete', [App\Http\Controllers\API\HorairesglobalController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_delete');
// la route des actions
    Route::get('horairesglobals/action', [App\Http\Controllers\API\HorairesglobalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_delete');
// la route des actions
    Route::post('horairesglobals/action', [App\Http\Controllers\API\HorairesglobalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairesglobals_api_delete');


//Route::resource('Horairesglobalspostes',App\Http\Controllers\API\HorairesglobalsposteController::class);
// les routes d'affichage
    Route::get('horairesglobalspostes/{key}/{val}', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_index2');
    Route::get('horairesglobalspostes', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_index');
    Route::post('horairesglobalspostes-Aggrid', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_aggrid');

// la route de creation
    Route::post('horairesglobalspostes', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_create');
// la route d'edition
    Route::post('horairesglobalspostes/{Horairesglobalspostes}/update', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_update');
// la route de suppression
    Route::post('horairesglobalspostes/{Horairesglobalspostes}/delete', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_delete');
// la route des actions
    Route::get('horairesglobalspostes/action', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_delete');
// la route des actions
    Route::post('horairesglobalspostes/action', [App\Http\Controllers\API\HorairesglobalsposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairesglobalspostes_api_delete');


//Route::resource('Horairesglobalstaches',App\Http\Controllers\API\HorairesglobalstacheController::class);
// les routes d'affichage
    Route::get('horairesglobalstaches/{key}/{val}', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_index2');
    Route::get('horairesglobalstaches', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_index');
    Route::post('horairesglobalstaches-Aggrid', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_aggrid');

// la route de creation
    Route::post('horairesglobalstaches', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_create');
// la route d'edition
    Route::post('horairesglobalstaches/{Horairesglobalstaches}/update', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_update');
// la route de suppression
    Route::post('horairesglobalstaches/{Horairesglobalstaches}/delete', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_delete');
// la route des actions
    Route::get('horairesglobalstaches/action', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_delete');
// la route des actions
    Route::post('horairesglobalstaches/action', [App\Http\Controllers\API\HorairesglobalstacheController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairesglobalstaches_api_delete');


//Route::resource('Horairestypespostes',App\Http\Controllers\API\HorairestypesposteController::class);
// les routes d'affichage
    Route::get('horairestypespostes/{key}/{val}', [App\Http\Controllers\API\HorairestypesposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_index2');
    Route::get('horairestypespostes', [App\Http\Controllers\API\HorairestypesposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_index');
    Route::post('horairestypespostes-Aggrid', [App\Http\Controllers\API\HorairestypesposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_aggrid');

// la route de creation
    Route::post('horairestypespostes', [App\Http\Controllers\API\HorairestypesposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_create');
// la route d'edition
    Route::post('horairestypespostes/{Horairestypespostes}/update', [App\Http\Controllers\API\HorairestypesposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_update');
// la route de suppression
    Route::post('horairestypespostes/{Horairestypespostes}/delete', [App\Http\Controllers\API\HorairestypesposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_delete');
// la route des actions
    Route::get('horairestypespostes/action', [App\Http\Controllers\API\HorairestypesposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_delete');
// la route des actions
    Route::post('horairestypespostes/action', [App\Http\Controllers\API\HorairestypesposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairestypespostes_api_delete');


//Route::resource('Horairestypessites',App\Http\Controllers\API\HorairestypessiteController::class);
// les routes d'affichage
    Route::get('horairestypessites/{key}/{val}', [App\Http\Controllers\API\HorairestypessiteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_index2');
    Route::get('horairestypessites', [App\Http\Controllers\API\HorairestypessiteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_index');
    Route::post('horairestypessites-Aggrid', [App\Http\Controllers\API\HorairestypessiteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Horairestypessites_api_aggrid');

// la route de creation
    Route::post('horairestypessites', [App\Http\Controllers\API\HorairestypessiteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_create');
// la route d'edition
    Route::post('horairestypessites/{Horairestypessites}/update', [App\Http\Controllers\API\HorairestypessiteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_update');
// la route de suppression
    Route::post('horairestypessites/{Horairestypessites}/delete', [App\Http\Controllers\API\HorairestypessiteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_delete');
// la route des actions
    Route::get('horairestypessites/action', [App\Http\Controllers\API\HorairestypessiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_delete');
// la route des actions
    Route::post('horairestypessites/action', [App\Http\Controllers\API\HorairestypessiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Horairestypessites_api_delete');


//Route::resource('Identifications',App\Http\Controllers\API\IdentificationController::class);
// les routes d'affichage
    Route::get('identifications/{key}/{val}', [App\Http\Controllers\API\IdentificationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Identifications_api_index2');
    Route::get('identifications', [App\Http\Controllers\API\IdentificationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Identifications_api_index');
    Route::post('identifications-Aggrid', [App\Http\Controllers\API\IdentificationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Identifications_api_aggrid');

// la route de creation
    Route::post('identifications', [App\Http\Controllers\API\IdentificationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Identifications_api_create');
// la route d'edition
    Route::post('identifications/{Identifications}/update', [App\Http\Controllers\API\IdentificationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Identifications_api_update');
// la route de suppression
    Route::post('identifications/{Identifications}/delete', [App\Http\Controllers\API\IdentificationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Identifications_api_delete');
// la route des actions
    Route::get('identifications/action', [App\Http\Controllers\API\IdentificationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Identifications_api_delete');
// la route des actions
    Route::post('identifications/action', [App\Http\Controllers\API\IdentificationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Identifications_api_delete');


//Route::resource('Imports',App\Http\Controllers\API\ImportController::class);
// les routes d'affichage
    Route::get('imports/{key}/{val}', [App\Http\Controllers\API\ImportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Imports_api_index2');
    Route::get('imports', [App\Http\Controllers\API\ImportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Imports_api_index');
    Route::post('imports-Aggrid', [App\Http\Controllers\API\ImportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Imports_api_aggrid');

// la route de creation
    Route::post('imports', [App\Http\Controllers\API\ImportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Imports_api_create');
// la route d'edition
    Route::post('imports/{Imports}/update', [App\Http\Controllers\API\ImportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Imports_api_update');
// la route de suppression
    Route::post('imports/{Imports}/delete', [App\Http\Controllers\API\ImportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Imports_api_delete');
// la route des actions
    Route::get('imports/action', [App\Http\Controllers\API\ImportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Imports_api_delete');
// la route des actions
    Route::post('imports/action', [App\Http\Controllers\API\ImportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Imports_api_delete');


//Route::resource('Interventiondetails',App\Http\Controllers\API\InterventiondetailController::class);
// les routes d'affichage
    Route::get('interventiondetails/{key}/{val}', [App\Http\Controllers\API\InterventiondetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_index2');
    Route::get('interventiondetails', [App\Http\Controllers\API\InterventiondetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_index');
    Route::post('interventiondetails-Aggrid', [App\Http\Controllers\API\InterventiondetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Interventiondetails_api_aggrid');

// la route de creation
    Route::post('interventiondetails', [App\Http\Controllers\API\InterventiondetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_create');
// la route d'edition
    Route::post('interventiondetails/{Interventiondetails}/update', [App\Http\Controllers\API\InterventiondetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_update');
// la route de suppression
    Route::post('interventiondetails/{Interventiondetails}/delete', [App\Http\Controllers\API\InterventiondetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_delete');
// la route des actions
    Route::get('interventiondetails/action', [App\Http\Controllers\API\InterventiondetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_delete');
// la route des actions
    Route::post('interventiondetails/action', [App\Http\Controllers\API\InterventiondetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventiondetails_api_delete');


//Route::resource('Interventionimages',App\Http\Controllers\API\InterventionimageController::class);
// les routes d'affichage
    Route::get('interventionimages/{key}/{val}', [App\Http\Controllers\API\InterventionimageController::class, 'data'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_index2');
    Route::get('interventionimages', [App\Http\Controllers\API\InterventionimageController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_index');
    Route::post('interventionimages-Aggrid', [App\Http\Controllers\API\InterventionimageController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Interventionimages_api_aggrid');

// la route de creation
    Route::post('interventionimages', [App\Http\Controllers\API\InterventionimageController::class, 'create'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_create');
// la route d'edition
    Route::post('interventionimages/{Interventionimages}/update', [App\Http\Controllers\API\InterventionimageController::class, 'update'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_update');
// la route de suppression
    Route::post('interventionimages/{Interventionimages}/delete', [App\Http\Controllers\API\InterventionimageController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_delete');
// la route des actions
    Route::get('interventionimages/action', [App\Http\Controllers\API\InterventionimageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_delete');
// la route des actions
    Route::post('interventionimages/action', [App\Http\Controllers\API\InterventionimageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventionimages_api_delete');


//Route::resource('Interventions',App\Http\Controllers\API\InterventionController::class);
// les routes d'affichage
    Route::get('interventions/{key}/{val}', [App\Http\Controllers\API\InterventionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Interventions_api_index2');
    Route::get('interventions', [App\Http\Controllers\API\InterventionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Interventions_api_index');
    Route::post('interventions-Aggrid', [App\Http\Controllers\API\InterventionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Interventions_api_aggrid');

// la route de creation
    Route::post('interventions', [App\Http\Controllers\API\InterventionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Interventions_api_create');
// la route d'edition
    Route::post('interventions/{Interventions}/update', [App\Http\Controllers\API\InterventionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Interventions_api_update');
// la route de suppression
    Route::post('interventions/{Interventions}/delete', [App\Http\Controllers\API\InterventionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Interventions_api_delete');
// la route des actions
    Route::get('interventions/action', [App\Http\Controllers\API\InterventionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventions_api_delete');
// la route des actions
    Route::post('interventions/action', [App\Http\Controllers\API\InterventionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventions_api_delete');


//Route::resource('Interventionusers',App\Http\Controllers\API\InterventionuserController::class);
// les routes d'affichage
    Route::get('interventionusers/{key}/{val}', [App\Http\Controllers\API\InterventionuserController::class, 'data'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_index2');
    Route::get('interventionusers', [App\Http\Controllers\API\InterventionuserController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_index');
    Route::post('interventionusers-Aggrid', [App\Http\Controllers\API\InterventionuserController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Interventionusers_api_aggrid');

// la route de creation
    Route::post('interventionusers', [App\Http\Controllers\API\InterventionuserController::class, 'create'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_create');
// la route d'edition
    Route::post('interventionusers/{Interventionusers}/update', [App\Http\Controllers\API\InterventionuserController::class, 'update'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_update');
// la route de suppression
    Route::post('interventionusers/{Interventionusers}/delete', [App\Http\Controllers\API\InterventionuserController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_delete');
// la route des actions
    Route::get('interventionusers/action', [App\Http\Controllers\API\InterventionuserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_delete');
// la route des actions
    Route::post('interventionusers/action', [App\Http\Controllers\API\InterventionuserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Interventionusers_api_delete');


//Route::resource('Jobs',App\Http\Controllers\API\JobController::class);
// les routes d'affichage
    Route::get('jobs/{key}/{val}', [App\Http\Controllers\API\JobController::class, 'data'])->withoutMiddleware("throttle:api")->name('Jobs_api_index2');
    Route::get('jobs', [App\Http\Controllers\API\JobController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Jobs_api_index');
    Route::post('jobs-Aggrid', [App\Http\Controllers\API\JobController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Jobs_api_aggrid');

// la route de creation
    Route::post('jobs', [App\Http\Controllers\API\JobController::class, 'create'])->withoutMiddleware("throttle:api")->name('Jobs_api_create');
// la route d'edition
    Route::post('jobs/{Jobs}/update', [App\Http\Controllers\API\JobController::class, 'update'])->withoutMiddleware("throttle:api")->name('Jobs_api_update');
// la route de suppression
    Route::post('jobs/{Jobs}/delete', [App\Http\Controllers\API\JobController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Jobs_api_delete');
// la route des actions
    Route::get('jobs/action', [App\Http\Controllers\API\JobController::class, 'action'])->withoutMiddleware("throttle:api")->name('Jobs_api_delete');
// la route des actions
    Route::post('jobs/action', [App\Http\Controllers\API\JobController::class, 'action'])->withoutMiddleware("throttle:api")->name('Jobs_api_delete');


//Route::resource('Joursferies',App\Http\Controllers\API\JoursferieController::class);
// les routes d'affichage
    Route::get('joursferies/{key}/{val}', [App\Http\Controllers\API\JoursferieController::class, 'data'])->withoutMiddleware("throttle:api")->name('Joursferies_api_index2');
    Route::get('joursferies', [App\Http\Controllers\API\JoursferieController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Joursferies_api_index');
    Route::post('joursferies-Aggrid', [App\Http\Controllers\API\JoursferieController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Joursferies_api_aggrid');

// la route de creation
    Route::post('joursferies', [App\Http\Controllers\API\JoursferieController::class, 'create'])->withoutMiddleware("throttle:api")->name('Joursferies_api_create');
// la route d'edition
    Route::post('joursferies/{Joursferies}/update', [App\Http\Controllers\API\JoursferieController::class, 'update'])->withoutMiddleware("throttle:api")->name('Joursferies_api_update');
// la route de suppression
    Route::post('joursferies/{Joursferies}/delete', [App\Http\Controllers\API\JoursferieController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Joursferies_api_delete');
// la route des actions
    Route::get('joursferies/action', [App\Http\Controllers\API\JoursferieController::class, 'action'])->withoutMiddleware("throttle:api")->name('Joursferies_api_delete');
// la route des actions
    Route::post('joursferies/action', [App\Http\Controllers\API\JoursferieController::class, 'action'])->withoutMiddleware("throttle:api")->name('Joursferies_api_delete');


//Route::resource('Lignes',App\Http\Controllers\API\LigneController::class);
// les routes d'affichage
    Route::get('lignes/{key}/{val}', [App\Http\Controllers\API\LigneController::class, 'data'])->withoutMiddleware("throttle:api")->name('Lignes_api_index2');
    Route::get('lignes', [App\Http\Controllers\API\LigneController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Lignes_api_index');
    Route::post('lignes-Aggrid', [App\Http\Controllers\API\LigneController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Lignes_api_aggrid');

// la route de creation
    Route::post('lignes', [App\Http\Controllers\API\LigneController::class, 'create'])->withoutMiddleware("throttle:api")->name('Lignes_api_create');
// la route d'edition
    Route::post('lignes/{Lignes}/update', [App\Http\Controllers\API\LigneController::class, 'update'])->withoutMiddleware("throttle:api")->name('Lignes_api_update');
// la route de suppression
    Route::post('lignes/{Lignes}/delete', [App\Http\Controllers\API\LigneController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Lignes_api_delete');
// la route des actions
    Route::get('lignes/action', [App\Http\Controllers\API\LigneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Lignes_api_delete');
// la route des actions
    Route::post('lignes/action', [App\Http\Controllers\API\LigneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Lignes_api_delete');


//Route::resource('Lignesmoyenstransports',App\Http\Controllers\API\LignesmoyenstransportController::class);
// les routes d'affichage
    Route::get('lignesmoyenstransports/{key}/{val}', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_index2');
    Route::get('lignesmoyenstransports', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_index');
    Route::post('lignesmoyenstransports-Aggrid', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_aggrid');

// la route de creation
    Route::post('lignesmoyenstransports', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_create');
// la route d'edition
    Route::post('lignesmoyenstransports/{Lignesmoyenstransports}/update', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_update');
// la route de suppression
    Route::post('lignesmoyenstransports/{Lignesmoyenstransports}/delete', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_delete');
// la route des actions
    Route::get('lignesmoyenstransports/action', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_delete');
// la route des actions
    Route::post('lignesmoyenstransports/action', [App\Http\Controllers\API\LignesmoyenstransportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Lignesmoyenstransports_api_delete');


//Route::resource('Listesappels',App\Http\Controllers\API\ListesappelController::class);
// les routes d'affichage
    Route::get('listesappels/{key}/{val}', [App\Http\Controllers\API\ListesappelController::class, 'data'])->withoutMiddleware("throttle:api")->name('Listesappels_api_index2');
    Route::get('listesappels', [App\Http\Controllers\API\ListesappelController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Listesappels_api_index');
    Route::post('listesappels-Aggrid', [App\Http\Controllers\API\ListesappelController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Listesappels_api_aggrid');

// la route de creation
    Route::post('listesappels', [App\Http\Controllers\API\ListesappelController::class, 'create'])->withoutMiddleware("throttle:api")->name('Listesappels_api_create');
// la route d'edition
    Route::post('listesappels/{Listesappels}/update', [App\Http\Controllers\API\ListesappelController::class, 'update'])->withoutMiddleware("throttle:api")->name('Listesappels_api_update');
// la route de suppression
    Route::post('listesappels/{Listesappels}/delete', [App\Http\Controllers\API\ListesappelController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Listesappels_api_delete');
// la route des actions
    Route::get('listesappels/action', [App\Http\Controllers\API\ListesappelController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listesappels_api_delete');
// la route des actions
    Route::post('listesappels/action', [App\Http\Controllers\API\ListesappelController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listesappels_api_delete');


//Route::resource('Listesappelsjours',App\Http\Controllers\API\ListesappelsjourController::class);
// les routes d'affichage
    Route::get('listesappelsjours/{key}/{val}', [App\Http\Controllers\API\ListesappelsjourController::class, 'data'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_index2');
    Route::get('listesappelsjours', [App\Http\Controllers\API\ListesappelsjourController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_index');
    Route::post('listesappelsjours-Aggrid', [App\Http\Controllers\API\ListesappelsjourController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_aggrid');

// la route de creation
    Route::post('listesappelsjours', [App\Http\Controllers\API\ListesappelsjourController::class, 'create'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_create');
// la route d'edition
    Route::post('listesappelsjours/{Listesappelsjours}/update', [App\Http\Controllers\API\ListesappelsjourController::class, 'update'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_update');
// la route de suppression
    Route::post('listesappelsjours/{Listesappelsjours}/delete', [App\Http\Controllers\API\ListesappelsjourController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_delete');
// la route des actions
    Route::get('listesappelsjours/action', [App\Http\Controllers\API\ListesappelsjourController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_delete');
// la route des actions
    Route::post('listesappelsjours/action', [App\Http\Controllers\API\ListesappelsjourController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listesappelsjours_api_delete');


//Route::resource('Listesjours',App\Http\Controllers\API\ListesjourController::class);
// les routes d'affichage
    Route::get('listesjours/{key}/{val}', [App\Http\Controllers\API\ListesjourController::class, 'data'])->withoutMiddleware("throttle:api")->name('Listesjours_api_index2');
    Route::get('listesjours', [App\Http\Controllers\API\ListesjourController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Listesjours_api_index');
    Route::post('listesjours-Aggrid', [App\Http\Controllers\API\ListesjourController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Listesjours_api_aggrid');

// la route de creation
    Route::post('listesjours', [App\Http\Controllers\API\ListesjourController::class, 'create'])->withoutMiddleware("throttle:api")->name('Listesjours_api_create');
// la route d'edition
    Route::post('listesjours/{Listesjours}/update', [App\Http\Controllers\API\ListesjourController::class, 'update'])->withoutMiddleware("throttle:api")->name('Listesjours_api_update');
// la route de suppression
    Route::post('listesjours/{Listesjours}/delete', [App\Http\Controllers\API\ListesjourController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Listesjours_api_delete');
// la route des actions
    Route::get('listesjours/action', [App\Http\Controllers\API\ListesjourController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listesjours_api_delete');
// la route des actions
    Route::post('listesjours/action', [App\Http\Controllers\API\ListesjourController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listesjours_api_delete');


//Route::resource('Listings',App\Http\Controllers\API\ListingController::class);
// les routes d'affichage
    Route::get('listings/{key}/{val}', [App\Http\Controllers\API\ListingController::class, 'data'])->withoutMiddleware("throttle:api")->name('Listings_api_index2');
    Route::get('listings', [App\Http\Controllers\API\ListingController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Listings_api_index');
    Route::post('listings-Aggrid', [App\Http\Controllers\API\ListingController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Listings_api_aggrid');

// la route de creation
    Route::post('listings', [App\Http\Controllers\API\ListingController::class, 'create'])->withoutMiddleware("throttle:api")->name('Listings_api_create');
// la route d'edition
    Route::post('listings/{Listings}/update', [App\Http\Controllers\API\ListingController::class, 'update'])->withoutMiddleware("throttle:api")->name('Listings_api_update');
// la route de suppression
    Route::post('listings/{Listings}/delete', [App\Http\Controllers\API\ListingController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Listings_api_delete');
// la route des actions
    Route::get('listings/action', [App\Http\Controllers\API\ListingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listings_api_delete');
// la route des actions
    Route::post('listings/action', [App\Http\Controllers\API\ListingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listings_api_delete');


//Route::resource('Listingsetats',App\Http\Controllers\API\ListingsetatController::class);
// les routes d'affichage
    Route::get('listingsetats/{key}/{val}', [App\Http\Controllers\API\ListingsetatController::class, 'data'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_index2');
    Route::get('listingsetats', [App\Http\Controllers\API\ListingsetatController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_index');
    Route::post('listingsetats-Aggrid', [App\Http\Controllers\API\ListingsetatController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Listingsetats_api_aggrid');

// la route de creation
    Route::post('listingsetats', [App\Http\Controllers\API\ListingsetatController::class, 'create'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_create');
// la route d'edition
    Route::post('listingsetats/{Listingsetats}/update', [App\Http\Controllers\API\ListingsetatController::class, 'update'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_update');
// la route de suppression
    Route::post('listingsetats/{Listingsetats}/delete', [App\Http\Controllers\API\ListingsetatController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_delete');
// la route des actions
    Route::get('listingsetats/action', [App\Http\Controllers\API\ListingsetatController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_delete');
// la route des actions
    Route::post('listingsetats/action', [App\Http\Controllers\API\ListingsetatController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listingsetats_api_delete');


//Route::resource('Listingsjours',App\Http\Controllers\API\ListingsjourController::class);
// les routes d'affichage
    Route::get('listingsjours/{key}/{val}', [App\Http\Controllers\API\ListingsjourController::class, 'data'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_index2');
    Route::get('listingsjours', [App\Http\Controllers\API\ListingsjourController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_index');
    Route::post('listingsjours-Aggrid', [App\Http\Controllers\API\ListingsjourController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Listingsjours_api_aggrid');

// la route de creation
    Route::post('listingsjours', [App\Http\Controllers\API\ListingsjourController::class, 'create'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_create');
// la route d'edition
    Route::post('listingsjours/{Listingsjours}/update', [App\Http\Controllers\API\ListingsjourController::class, 'update'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_update');
// la route de suppression
    Route::post('listingsjours/{Listingsjours}/delete', [App\Http\Controllers\API\ListingsjourController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_delete');
// la route des actions
    Route::get('listingsjours/action', [App\Http\Controllers\API\ListingsjourController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_delete');
// la route des actions
    Route::post('listingsjours/action', [App\Http\Controllers\API\ListingsjourController::class, 'action'])->withoutMiddleware("throttle:api")->name('Listingsjours_api_delete');


//Route::resource('Logins',App\Http\Controllers\API\LoginController::class);
// les routes d'affichage
    Route::get('logins/{key}/{val}', [App\Http\Controllers\API\LoginController::class, 'data'])->withoutMiddleware("throttle:api")->name('Logins_api_index2');
    Route::get('logins', [App\Http\Controllers\API\LoginController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Logins_api_index');
    Route::post('logins-Aggrid', [App\Http\Controllers\API\LoginController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Logins_api_aggrid');

// la route de creation
    Route::post('logins', [App\Http\Controllers\API\LoginController::class, 'create'])->withoutMiddleware("throttle:api")->name('Logins_api_create');
// la route d'edition
    Route::post('logins/{Logins}/update', [App\Http\Controllers\API\LoginController::class, 'update'])->withoutMiddleware("throttle:api")->name('Logins_api_update');
// la route de suppression
    Route::post('logins/{Logins}/delete', [App\Http\Controllers\API\LoginController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Logins_api_delete');
// la route des actions
    Route::get('logins/action', [App\Http\Controllers\API\LoginController::class, 'action'])->withoutMiddleware("throttle:api")->name('Logins_api_delete');
// la route des actions
    Route::post('logins/action', [App\Http\Controllers\API\LoginController::class, 'action'])->withoutMiddleware("throttle:api")->name('Logins_api_delete');


//Route::resource('Logs',App\Http\Controllers\API\LogController::class);
// les routes d'affichage
    Route::get('logs/{key}/{val}', [App\Http\Controllers\API\LogController::class, 'data'])->withoutMiddleware("throttle:api")->name('Logs_api_index2');
    Route::get('logs', [App\Http\Controllers\API\LogController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Logs_api_index');
    Route::post('logs-Aggrid', [App\Http\Controllers\API\LogController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Logs_api_aggrid');

// la route de creation
    Route::post('logs', [App\Http\Controllers\API\LogController::class, 'create'])->withoutMiddleware("throttle:api")->name('Logs_api_create');
// la route d'edition
    Route::post('logs/{Logs}/update', [App\Http\Controllers\API\LogController::class, 'update'])->withoutMiddleware("throttle:api")->name('Logs_api_update');
// la route de suppression
    Route::post('logs/{Logs}/delete', [App\Http\Controllers\API\LogController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Logs_api_delete');
// la route des actions
    Route::get('logs/action', [App\Http\Controllers\API\LogController::class, 'action'])->withoutMiddleware("throttle:api")->name('Logs_api_delete');
// la route des actions
    Route::post('logs/action', [App\Http\Controllers\API\LogController::class, 'action'])->withoutMiddleware("throttle:api")->name('Logs_api_delete');


//Route::resource('Materielinterventiondetails',App\Http\Controllers\API\MaterielinterventiondetailController::class);
// les routes d'affichage
    Route::get('materielinterventiondetails/{key}/{val}', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_index2');
    Route::get('materielinterventiondetails', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_index');
    Route::post('materielinterventiondetails-Aggrid', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_aggrid');

// la route de creation
    Route::post('materielinterventiondetails', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_create');
// la route d'edition
    Route::post('materielinterventiondetails/{Materielinterventiondetails}/update', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_update');
// la route de suppression
    Route::post('materielinterventiondetails/{Materielinterventiondetails}/delete', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_delete');
// la route des actions
    Route::get('materielinterventiondetails/action', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_delete');
// la route des actions
    Route::post('materielinterventiondetails/action', [App\Http\Controllers\API\MaterielinterventiondetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materielinterventiondetails_api_delete');


//Route::resource('Materielinterventions',App\Http\Controllers\API\MaterielinterventionController::class);
// les routes d'affichage
    Route::get('materielinterventions/{key}/{val}', [App\Http\Controllers\API\MaterielinterventionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_index2');
    Route::get('materielinterventions', [App\Http\Controllers\API\MaterielinterventionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_index');
    Route::post('materielinterventions-Aggrid', [App\Http\Controllers\API\MaterielinterventionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Materielinterventions_api_aggrid');

// la route de creation
    Route::post('materielinterventions', [App\Http\Controllers\API\MaterielinterventionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_create');
// la route d'edition
    Route::post('materielinterventions/{Materielinterventions}/update', [App\Http\Controllers\API\MaterielinterventionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_update');
// la route de suppression
    Route::post('materielinterventions/{Materielinterventions}/delete', [App\Http\Controllers\API\MaterielinterventionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_delete');
// la route des actions
    Route::get('materielinterventions/action', [App\Http\Controllers\API\MaterielinterventionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_delete');
// la route des actions
    Route::post('materielinterventions/action', [App\Http\Controllers\API\MaterielinterventionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materielinterventions_api_delete');


//Route::resource('Materielprevisionnels',App\Http\Controllers\API\MaterielprevisionnelController::class);
// les routes d'affichage
    Route::get('materielprevisionnels/{key}/{val}', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'data'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_index2');
    Route::get('materielprevisionnels', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_index');
    Route::post('materielprevisionnels-Aggrid', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_aggrid');

// la route de creation
    Route::post('materielprevisionnels', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'create'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_create');
// la route d'edition
    Route::post('materielprevisionnels/{Materielprevisionnels}/update', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'update'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_update');
// la route de suppression
    Route::post('materielprevisionnels/{Materielprevisionnels}/delete', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_delete');
// la route des actions
    Route::get('materielprevisionnels/action', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_delete');
// la route des actions
    Route::post('materielprevisionnels/action', [App\Http\Controllers\API\MaterielprevisionnelController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materielprevisionnels_api_delete');


//Route::resource('Materiels',App\Http\Controllers\API\MaterielController::class);
// les routes d'affichage
    Route::get('materiels/{key}/{val}', [App\Http\Controllers\API\MaterielController::class, 'data'])->withoutMiddleware("throttle:api")->name('Materiels_api_index2');
    Route::get('materiels', [App\Http\Controllers\API\MaterielController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Materiels_api_index');
    Route::post('materiels-Aggrid', [App\Http\Controllers\API\MaterielController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Materiels_api_aggrid');

// la route de creation
    Route::post('materiels', [App\Http\Controllers\API\MaterielController::class, 'create'])->withoutMiddleware("throttle:api")->name('Materiels_api_create');
// la route d'edition
    Route::post('materiels/{Materiels}/update', [App\Http\Controllers\API\MaterielController::class, 'update'])->withoutMiddleware("throttle:api")->name('Materiels_api_update');
// la route de suppression
    Route::post('materiels/{Materiels}/delete', [App\Http\Controllers\API\MaterielController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Materiels_api_delete');
// la route des actions
    Route::get('materiels/action', [App\Http\Controllers\API\MaterielController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materiels_api_delete');
// la route des actions
    Route::post('materiels/action', [App\Http\Controllers\API\MaterielController::class, 'action'])->withoutMiddleware("throttle:api")->name('Materiels_api_delete');


//Route::resource('Matrices',App\Http\Controllers\API\MatriceController::class);
// les routes d'affichage
    Route::get('matrices/{key}/{val}', [App\Http\Controllers\API\MatriceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Matrices_api_index2');
    Route::get('matrices', [App\Http\Controllers\API\MatriceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Matrices_api_index');
    Route::post('matrices-Aggrid', [App\Http\Controllers\API\MatriceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Matrices_api_aggrid');

// la route de creation
    Route::post('matrices', [App\Http\Controllers\API\MatriceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Matrices_api_create');
// la route d'edition
    Route::post('matrices/{Matrices}/update', [App\Http\Controllers\API\MatriceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Matrices_api_update');
// la route de suppression
    Route::post('matrices/{Matrices}/delete', [App\Http\Controllers\API\MatriceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Matrices_api_delete');
// la route des actions
    Route::get('matrices/action', [App\Http\Controllers\API\MatriceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Matrices_api_delete');
// la route des actions
    Route::post('matrices/action', [App\Http\Controllers\API\MatriceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Matrices_api_delete');


//Route::resource('Matrimoniales',App\Http\Controllers\API\MatrimonialeController::class);
// les routes d'affichage
    Route::get('matrimoniales/{key}/{val}', [App\Http\Controllers\API\MatrimonialeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_index2');
    Route::get('matrimoniales', [App\Http\Controllers\API\MatrimonialeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_index');
    Route::post('matrimoniales-Aggrid', [App\Http\Controllers\API\MatrimonialeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Matrimoniales_api_aggrid');

// la route de creation
    Route::post('matrimoniales', [App\Http\Controllers\API\MatrimonialeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_create');
// la route d'edition
    Route::post('matrimoniales/{Matrimoniales}/update', [App\Http\Controllers\API\MatrimonialeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_update');
// la route de suppression
    Route::post('matrimoniales/{Matrimoniales}/delete', [App\Http\Controllers\API\MatrimonialeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_delete');
// la route des actions
    Route::get('matrimoniales/action', [App\Http\Controllers\API\MatrimonialeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_delete');
// la route des actions
    Route::post('matrimoniales/action', [App\Http\Controllers\API\MatrimonialeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Matrimoniales_api_delete');


//Route::resource('Menus',App\Http\Controllers\API\MenuController::class);
// les routes d'affichage
    Route::get('menus/{key}/{val}', [App\Http\Controllers\API\MenuController::class, 'data'])->withoutMiddleware("throttle:api")->name('Menus_api_index2');
    Route::get('menus', [App\Http\Controllers\API\MenuController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Menus_api_index');
    Route::post('menus-Aggrid', [App\Http\Controllers\API\MenuController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Menus_api_aggrid');

// la route de creation
    Route::post('menus', [App\Http\Controllers\API\MenuController::class, 'create'])->withoutMiddleware("throttle:api")->name('Menus_api_create');
// la route d'edition
    Route::post('menus/{Menus}/update', [App\Http\Controllers\API\MenuController::class, 'update'])->withoutMiddleware("throttle:api")->name('Menus_api_update');
// la route de suppression
    Route::post('menus/{Menus}/delete', [App\Http\Controllers\API\MenuController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Menus_api_delete');
// la route des actions
    Route::get('menus/action', [App\Http\Controllers\API\MenuController::class, 'action'])->withoutMiddleware("throttle:api")->name('Menus_api_delete');
// la route des actions
    Route::post('menus/action', [App\Http\Controllers\API\MenuController::class, 'action'])->withoutMiddleware("throttle:api")->name('Menus_api_delete');


//Route::resource('Mesurespreventives',App\Http\Controllers\API\MesurespreventiveController::class);
// les routes d'affichage
    Route::get('mesurespreventives/{key}/{val}', [App\Http\Controllers\API\MesurespreventiveController::class, 'data'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_index2');
    Route::get('mesurespreventives', [App\Http\Controllers\API\MesurespreventiveController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_index');
    Route::post('mesurespreventives-Aggrid', [App\Http\Controllers\API\MesurespreventiveController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_aggrid');

// la route de creation
    Route::post('mesurespreventives', [App\Http\Controllers\API\MesurespreventiveController::class, 'create'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_create');
// la route d'edition
    Route::post('mesurespreventives/{Mesurespreventives}/update', [App\Http\Controllers\API\MesurespreventiveController::class, 'update'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_update');
// la route de suppression
    Route::post('mesurespreventives/{Mesurespreventives}/delete', [App\Http\Controllers\API\MesurespreventiveController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_delete');
// la route des actions
    Route::get('mesurespreventives/action', [App\Http\Controllers\API\MesurespreventiveController::class, 'action'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_delete');
// la route des actions
    Route::post('mesurespreventives/action', [App\Http\Controllers\API\MesurespreventiveController::class, 'action'])->withoutMiddleware("throttle:api")->name('Mesurespreventives_api_delete');


//Route::resource('Model_has_permissions',App\Http\Controllers\API\ModelHasPermissionController::class);
// les routes d'affichage
    Route::get('model_has_permissions/{key}/{val}', [App\Http\Controllers\API\ModelHasPermissionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_index2');
    Route::get('model_has_permissions', [App\Http\Controllers\API\ModelHasPermissionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_index');
    Route::post('model_has_permissions-Aggrid', [App\Http\Controllers\API\ModelHasPermissionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_aggrid');

// la route de creation
    Route::post('model_has_permissions', [App\Http\Controllers\API\ModelHasPermissionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_create');
// la route d'edition
    Route::post('model_has_permissions/{Model_has_permissions}/update', [App\Http\Controllers\API\ModelHasPermissionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_update');
// la route de suppression
    Route::post('model_has_permissions/{Model_has_permissions}/delete', [App\Http\Controllers\API\ModelHasPermissionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_delete');
// la route des actions
    Route::get('model_has_permissions/action', [App\Http\Controllers\API\ModelHasPermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_delete');
// la route des actions
    Route::post('model_has_permissions/action', [App\Http\Controllers\API\ModelHasPermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Model_has_permissions_api_delete');


//Route::resource('Model_has_roles',App\Http\Controllers\API\ModelHasRoleController::class);
// les routes d'affichage
    Route::get('model_has_roles/{key}/{val}', [App\Http\Controllers\API\ModelHasRoleController::class, 'data'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_index2');
    Route::get('model_has_roles', [App\Http\Controllers\API\ModelHasRoleController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_index');
    Route::post('model_has_roles-Aggrid', [App\Http\Controllers\API\ModelHasRoleController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Model_has_roles_api_aggrid');

// la route de creation
    Route::post('model_has_roles', [App\Http\Controllers\API\ModelHasRoleController::class, 'create'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_create');
// la route d'edition
    Route::post('model_has_roles/{Model_has_roles}/update', [App\Http\Controllers\API\ModelHasRoleController::class, 'update'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_update');
// la route de suppression
    Route::post('model_has_roles/{Model_has_roles}/delete', [App\Http\Controllers\API\ModelHasRoleController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_delete');
// la route des actions
    Route::get('model_has_roles/action', [App\Http\Controllers\API\ModelHasRoleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_delete');
// la route des actions
    Route::post('model_has_roles/action', [App\Http\Controllers\API\ModelHasRoleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Model_has_roles_api_delete');


//Route::resource('Modelslistings',App\Http\Controllers\API\ModelslistingController::class);
// les routes d'affichage
    Route::get('modelslistings/{key}/{val}', [App\Http\Controllers\API\ModelslistingController::class, 'data'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_index2');
    Route::get('modelslistings', [App\Http\Controllers\API\ModelslistingController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_index');
    Route::post('modelslistings-Aggrid', [App\Http\Controllers\API\ModelslistingController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Modelslistings_api_aggrid');

// la route de creation
    Route::post('modelslistings', [App\Http\Controllers\API\ModelslistingController::class, 'create'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_create');
// la route d'edition
    Route::post('modelslistings/{Modelslistings}/update', [App\Http\Controllers\API\ModelslistingController::class, 'update'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_update');
// la route de suppression
    Route::post('modelslistings/{Modelslistings}/delete', [App\Http\Controllers\API\ModelslistingController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_delete');
// la route des actions
    Route::get('modelslistings/action', [App\Http\Controllers\API\ModelslistingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_delete');
// la route des actions
    Route::post('modelslistings/action', [App\Http\Controllers\API\ModelslistingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Modelslistings_api_delete');


//Route::resource('Moyenstransports',App\Http\Controllers\API\MoyenstransportController::class);
// les routes d'affichage
    Route::get('moyenstransports/{key}/{val}', [App\Http\Controllers\API\MoyenstransportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_index2');
    Route::get('moyenstransports', [App\Http\Controllers\API\MoyenstransportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_index');
    Route::post('moyenstransports-Aggrid', [App\Http\Controllers\API\MoyenstransportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Moyenstransports_api_aggrid');

// la route de creation
    Route::post('moyenstransports', [App\Http\Controllers\API\MoyenstransportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_create');
// la route d'edition
    Route::post('moyenstransports/{Moyenstransports}/update', [App\Http\Controllers\API\MoyenstransportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_update');
// la route de suppression
    Route::post('moyenstransports/{Moyenstransports}/delete', [App\Http\Controllers\API\MoyenstransportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_delete');
// la route des actions
    Route::get('moyenstransports/action', [App\Http\Controllers\API\MoyenstransportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_delete');
// la route des actions
    Route::post('moyenstransports/action', [App\Http\Controllers\API\MoyenstransportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Moyenstransports_api_delete');


//Route::resource('Nationalites',App\Http\Controllers\API\NationaliteController::class);
// les routes d'affichage
    Route::get('nationalites/{key}/{val}', [App\Http\Controllers\API\NationaliteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Nationalites_api_index2');
    Route::get('nationalites', [App\Http\Controllers\API\NationaliteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Nationalites_api_index');
    Route::post('nationalites-Aggrid', [App\Http\Controllers\API\NationaliteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Nationalites_api_aggrid');

// la route de creation
    Route::post('nationalites', [App\Http\Controllers\API\NationaliteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Nationalites_api_create');
// la route d'edition
    Route::post('nationalites/{Nationalites}/update', [App\Http\Controllers\API\NationaliteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Nationalites_api_update');
// la route de suppression
    Route::post('nationalites/{Nationalites}/delete', [App\Http\Controllers\API\NationaliteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Nationalites_api_delete');
// la route des actions
    Route::get('nationalites/action', [App\Http\Controllers\API\NationaliteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Nationalites_api_delete');
// la route des actions
    Route::post('nationalites/action', [App\Http\Controllers\API\NationaliteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Nationalites_api_delete');


//Route::resource('Oauth_access_tokens',App\Http\Controllers\API\OauthAccessTokenController::class);
// les routes d'affichage
    Route::get('oauth_access_tokens/{key}/{val}', [App\Http\Controllers\API\OauthAccessTokenController::class, 'data'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_index2');
    Route::get('oauth_access_tokens', [App\Http\Controllers\API\OauthAccessTokenController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_index');
    Route::post('oauth_access_tokens-Aggrid', [App\Http\Controllers\API\OauthAccessTokenController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_aggrid');

// la route de creation
    Route::post('oauth_access_tokens', [App\Http\Controllers\API\OauthAccessTokenController::class, 'create'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_create');
// la route d'edition
    Route::post('oauth_access_tokens/{Oauth_access_tokens}/update', [App\Http\Controllers\API\OauthAccessTokenController::class, 'update'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_update');
// la route de suppression
    Route::post('oauth_access_tokens/{Oauth_access_tokens}/delete', [App\Http\Controllers\API\OauthAccessTokenController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_delete');
// la route des actions
    Route::get('oauth_access_tokens/action', [App\Http\Controllers\API\OauthAccessTokenController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_delete');
// la route des actions
    Route::post('oauth_access_tokens/action', [App\Http\Controllers\API\OauthAccessTokenController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_access_tokens_api_delete');


//Route::resource('Oauth_auth_codes',App\Http\Controllers\API\OauthAuthCodeController::class);
// les routes d'affichage
    Route::get('oauth_auth_codes/{key}/{val}', [App\Http\Controllers\API\OauthAuthCodeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_index2');
    Route::get('oauth_auth_codes', [App\Http\Controllers\API\OauthAuthCodeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_index');
    Route::post('oauth_auth_codes-Aggrid', [App\Http\Controllers\API\OauthAuthCodeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_aggrid');

// la route de creation
    Route::post('oauth_auth_codes', [App\Http\Controllers\API\OauthAuthCodeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_create');
// la route d'edition
    Route::post('oauth_auth_codes/{Oauth_auth_codes}/update', [App\Http\Controllers\API\OauthAuthCodeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_update');
// la route de suppression
    Route::post('oauth_auth_codes/{Oauth_auth_codes}/delete', [App\Http\Controllers\API\OauthAuthCodeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_delete');
// la route des actions
    Route::get('oauth_auth_codes/action', [App\Http\Controllers\API\OauthAuthCodeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_delete');
// la route des actions
    Route::post('oauth_auth_codes/action', [App\Http\Controllers\API\OauthAuthCodeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_auth_codes_api_delete');


//Route::resource('Oauth_clients',App\Http\Controllers\API\OauthClientController::class);
// les routes d'affichage
    Route::get('oauth_clients/{key}/{val}', [App\Http\Controllers\API\OauthClientController::class, 'data'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_index2');
    Route::get('oauth_clients', [App\Http\Controllers\API\OauthClientController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_index');
    Route::post('oauth_clients-Aggrid', [App\Http\Controllers\API\OauthClientController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Oauth_clients_api_aggrid');

// la route de creation
    Route::post('oauth_clients', [App\Http\Controllers\API\OauthClientController::class, 'create'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_create');
// la route d'edition
    Route::post('oauth_clients/{Oauth_clients}/update', [App\Http\Controllers\API\OauthClientController::class, 'update'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_update');
// la route de suppression
    Route::post('oauth_clients/{Oauth_clients}/delete', [App\Http\Controllers\API\OauthClientController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_delete');
// la route des actions
    Route::get('oauth_clients/action', [App\Http\Controllers\API\OauthClientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_delete');
// la route des actions
    Route::post('oauth_clients/action', [App\Http\Controllers\API\OauthClientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_clients_api_delete');


//Route::resource('Oauth_personal_access_clients',App\Http\Controllers\API\OauthPersonalAccessClientController::class);
// les routes d'affichage
    Route::get('oauth_personal_access_clients/{key}/{val}', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'data'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_index2');
    Route::get('oauth_personal_access_clients', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_index');
    Route::post('oauth_personal_access_clients-Aggrid', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_aggrid');

// la route de creation
    Route::post('oauth_personal_access_clients', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'create'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_create');
// la route d'edition
    Route::post('oauth_personal_access_clients/{Oauth_personal_access_clients}/update', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'update'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_update');
// la route de suppression
    Route::post('oauth_personal_access_clients/{Oauth_personal_access_clients}/delete', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_delete');
// la route des actions
    Route::get('oauth_personal_access_clients/action', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_delete');
// la route des actions
    Route::post('oauth_personal_access_clients/action', [App\Http\Controllers\API\OauthPersonalAccessClientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_personal_access_clients_api_delete');


//Route::resource('Oauth_refresh_tokens',App\Http\Controllers\API\OauthRefreshTokenController::class);
// les routes d'affichage
    Route::get('oauth_refresh_tokens/{key}/{val}', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'data'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_index2');
    Route::get('oauth_refresh_tokens', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_index');
    Route::post('oauth_refresh_tokens-Aggrid', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_aggrid');

// la route de creation
    Route::post('oauth_refresh_tokens', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'create'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_create');
// la route d'edition
    Route::post('oauth_refresh_tokens/{Oauth_refresh_tokens}/update', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'update'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_update');
// la route de suppression
    Route::post('oauth_refresh_tokens/{Oauth_refresh_tokens}/delete', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_delete');
// la route des actions
    Route::get('oauth_refresh_tokens/action', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_delete');
// la route des actions
    Route::post('oauth_refresh_tokens/action', [App\Http\Controllers\API\OauthRefreshTokenController::class, 'action'])->withoutMiddleware("throttle:api")->name('Oauth_refresh_tokens_api_delete');


//Route::resource('Objectifs',App\Http\Controllers\API\ObjectifController::class);
// les routes d'affichage
    Route::get('objectifs/{key}/{val}', [App\Http\Controllers\API\ObjectifController::class, 'data'])->withoutMiddleware("throttle:api")->name('Objectifs_api_index2');
    Route::get('objectifs', [App\Http\Controllers\API\ObjectifController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Objectifs_api_index');
    Route::post('objectifs-Aggrid', [App\Http\Controllers\API\ObjectifController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Objectifs_api_aggrid');

// la route de creation
    Route::post('objectifs', [App\Http\Controllers\API\ObjectifController::class, 'create'])->withoutMiddleware("throttle:api")->name('Objectifs_api_create');
// la route d'edition
    Route::post('objectifs/{Objectifs}/update', [App\Http\Controllers\API\ObjectifController::class, 'update'])->withoutMiddleware("throttle:api")->name('Objectifs_api_update');
// la route de suppression
    Route::post('objectifs/{Objectifs}/delete', [App\Http\Controllers\API\ObjectifController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Objectifs_api_delete');
// la route des actions
    Route::get('objectifs/action', [App\Http\Controllers\API\ObjectifController::class, 'action'])->withoutMiddleware("throttle:api")->name('Objectifs_api_delete');
// la route des actions
    Route::post('objectifs/action', [App\Http\Controllers\API\ObjectifController::class, 'action'])->withoutMiddleware("throttle:api")->name('Objectifs_api_delete');


//Route::resource('Onlines',App\Http\Controllers\API\OnlineController::class);
// les routes d'affichage
    Route::get('onlines/{key}/{val}', [App\Http\Controllers\API\OnlineController::class, 'data'])->withoutMiddleware("throttle:api")->name('Onlines_api_index2');
    Route::get('onlines', [App\Http\Controllers\API\OnlineController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Onlines_api_index');
    Route::post('onlines-Aggrid', [App\Http\Controllers\API\OnlineController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Onlines_api_aggrid');

// la route de creation
    Route::post('onlines', [App\Http\Controllers\API\OnlineController::class, 'create'])->withoutMiddleware("throttle:api")->name('Onlines_api_create');
// la route d'edition
    Route::post('onlines/{Onlines}/update', [App\Http\Controllers\API\OnlineController::class, 'update'])->withoutMiddleware("throttle:api")->name('Onlines_api_update');
// la route de suppression
    Route::post('onlines/{Onlines}/delete', [App\Http\Controllers\API\OnlineController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Onlines_api_delete');
// la route des actions
    Route::get('onlines/action', [App\Http\Controllers\API\OnlineController::class, 'action'])->withoutMiddleware("throttle:api")->name('Onlines_api_delete');
// la route des actions
    Route::post('onlines/action', [App\Http\Controllers\API\OnlineController::class, 'action'])->withoutMiddleware("throttle:api")->name('Onlines_api_delete');


//Route::resource('Passagesrondes',App\Http\Controllers\API\PassagesrondeController::class);
// les routes d'affichage
    Route::get('passagesrondes/{key}/{val}', [App\Http\Controllers\API\PassagesrondeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_index2');
    Route::get('passagesrondes', [App\Http\Controllers\API\PassagesrondeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_index');
    Route::post('passagesrondes-Aggrid', [App\Http\Controllers\API\PassagesrondeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Passagesrondes_api_aggrid');

// la route de creation
    Route::post('passagesrondes', [App\Http\Controllers\API\PassagesrondeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_create');
// la route d'edition
    Route::post('passagesrondes/{Passagesrondes}/update', [App\Http\Controllers\API\PassagesrondeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_update');
// la route de suppression
    Route::post('passagesrondes/{Passagesrondes}/delete', [App\Http\Controllers\API\PassagesrondeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_delete');
// la route des actions
    Route::get('passagesrondes/action', [App\Http\Controllers\API\PassagesrondeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_delete');
// la route des actions
    Route::post('passagesrondes/action', [App\Http\Controllers\API\PassagesrondeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Passagesrondes_api_delete');


//Route::resource('Pastilles',App\Http\Controllers\API\PastilleController::class);
// les routes d'affichage
    Route::get('pastilles/{key}/{val}', [App\Http\Controllers\API\PastilleController::class, 'data'])->withoutMiddleware("throttle:api")->name('Pastilles_api_index2');
    Route::get('pastilles', [App\Http\Controllers\API\PastilleController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Pastilles_api_index');
    Route::post('pastilles-Aggrid', [App\Http\Controllers\API\PastilleController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Pastilles_api_aggrid');

// la route de creation
    Route::post('pastilles', [App\Http\Controllers\API\PastilleController::class, 'create'])->withoutMiddleware("throttle:api")->name('Pastilles_api_create');
// la route d'edition
    Route::post('pastilles/{Pastilles}/update', [App\Http\Controllers\API\PastilleController::class, 'update'])->withoutMiddleware("throttle:api")->name('Pastilles_api_update');
// la route de suppression
    Route::post('pastilles/{Pastilles}/delete', [App\Http\Controllers\API\PastilleController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Pastilles_api_delete');
// la route des actions
    Route::get('pastilles/action', [App\Http\Controllers\API\PastilleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pastilles_api_delete');
// la route des actions
    Route::post('pastilles/action', [App\Http\Controllers\API\PastilleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pastilles_api_delete');


//Route::resource('Permissions',App\Http\Controllers\API\PermissionController::class);
// les routes d'affichage
    Route::get('permissions/{key}/{val}', [App\Http\Controllers\API\PermissionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Permissions_api_index2');
    Route::get('permissions', [App\Http\Controllers\API\PermissionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Permissions_api_index');
    Route::post('permissions-Aggrid', [App\Http\Controllers\API\PermissionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Permissions_api_aggrid');

// la route de creation
    Route::post('permissions', [App\Http\Controllers\API\PermissionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Permissions_api_create');
// la route d'edition
    Route::post('permissions/{Permissions}/update', [App\Http\Controllers\API\PermissionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Permissions_api_update');
// la route de suppression
    Route::post('permissions/{Permissions}/delete', [App\Http\Controllers\API\PermissionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Permissions_api_delete');
// la route des actions
    Route::get('permissions/action', [App\Http\Controllers\API\PermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Permissions_api_delete');
// la route des actions
    Route::post('permissions/action', [App\Http\Controllers\API\PermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Permissions_api_delete');


//Route::resource('Permissionsdetails',App\Http\Controllers\API\PermissionsdetailController::class);
// les routes d'affichage
    Route::get('permissionsdetails/{key}/{val}', [App\Http\Controllers\API\PermissionsdetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_index2');
    Route::get('permissionsdetails', [App\Http\Controllers\API\PermissionsdetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_index');
    Route::post('permissionsdetails-Aggrid', [App\Http\Controllers\API\PermissionsdetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_aggrid');

// la route de creation
    Route::post('permissionsdetails', [App\Http\Controllers\API\PermissionsdetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_create');
// la route d'edition
    Route::post('permissionsdetails/{Permissionsdetails}/update', [App\Http\Controllers\API\PermissionsdetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_update');
// la route de suppression
    Route::post('permissionsdetails/{Permissionsdetails}/delete', [App\Http\Controllers\API\PermissionsdetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_delete');
// la route des actions
    Route::get('permissionsdetails/action', [App\Http\Controllers\API\PermissionsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_delete');
// la route des actions
    Route::post('permissionsdetails/action', [App\Http\Controllers\API\PermissionsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Permissionsdetails_api_delete');


//Route::resource('Perms',App\Http\Controllers\API\PermController::class);
// les routes d'affichage
    Route::get('perms/{key}/{val}', [App\Http\Controllers\API\PermController::class, 'data'])->withoutMiddleware("throttle:api")->name('Perms_api_index2');
    Route::get('perms', [App\Http\Controllers\API\PermController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Perms_api_index');
    Route::post('perms-Aggrid', [App\Http\Controllers\API\PermController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Perms_api_aggrid');

// la route de creation
    Route::post('perms', [App\Http\Controllers\API\PermController::class, 'create'])->withoutMiddleware("throttle:api")->name('Perms_api_create');
// la route d'edition
    Route::post('perms/{Perms}/update', [App\Http\Controllers\API\PermController::class, 'update'])->withoutMiddleware("throttle:api")->name('Perms_api_update');
// la route de suppression
    Route::post('perms/{Perms}/delete', [App\Http\Controllers\API\PermController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Perms_api_delete');
// la route des actions
    Route::get('perms/action', [App\Http\Controllers\API\PermController::class, 'action'])->withoutMiddleware("throttle:api")->name('Perms_api_delete');
// la route des actions
    Route::post('perms/action', [App\Http\Controllers\API\PermController::class, 'action'])->withoutMiddleware("throttle:api")->name('Perms_api_delete');


//Route::resource('Pointages',App\Http\Controllers\API\PointageController::class);
// les routes d'affichage
    Route::get('pointages/{key}/{val}', [App\Http\Controllers\API\PointageController::class, 'data'])->withoutMiddleware("throttle:api")->name('Pointages_api_index2');
    Route::get('pointages', [App\Http\Controllers\API\PointageController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Pointages_api_index');
    Route::post('pointages-Aggrid', [App\Http\Controllers\API\PointageController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Pointages_api_aggrid');

// la route de creation
    Route::post('pointages', [App\Http\Controllers\API\PointageController::class, 'create'])->withoutMiddleware("throttle:api")->name('Pointages_api_create');
// la route d'edition
    Route::post('pointages/{Pointages}/update', [App\Http\Controllers\API\PointageController::class, 'update'])->withoutMiddleware("throttle:api")->name('Pointages_api_update');
// la route de suppression
    Route::post('pointages/{Pointages}/delete', [App\Http\Controllers\API\PointageController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Pointages_api_delete');
// la route des actions
    Route::get('pointages/action', [App\Http\Controllers\API\PointageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointages_api_delete');
// la route des actions
    Route::post('pointages/action', [App\Http\Controllers\API\PointageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointages_api_delete');


//Route::resource('Pointeuses',App\Http\Controllers\API\PointeuseController::class);
// les routes d'affichage
    Route::get('pointeuses/{key}/{val}', [App\Http\Controllers\API\PointeuseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_index2');
    Route::get('pointeuses', [App\Http\Controllers\API\PointeuseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_index');
    Route::post('pointeuses-Aggrid', [App\Http\Controllers\API\PointeuseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Pointeuses_api_aggrid');

// la route de creation
    Route::post('pointeuses', [App\Http\Controllers\API\PointeuseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_create');
// la route d'edition
    Route::post('pointeuses/{Pointeuses}/update', [App\Http\Controllers\API\PointeuseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_update');
// la route de suppression
    Route::post('pointeuses/{Pointeuses}/delete', [App\Http\Controllers\API\PointeuseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_delete');
// la route des actions
    Route::get('pointeuses/action', [App\Http\Controllers\API\PointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_delete');
// la route des actions
    Route::post('pointeuses/action', [App\Http\Controllers\API\PointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointeuses_api_delete');


//Route::resource('Pointeusestransactions',App\Http\Controllers\API\PointeusestransactionController::class);
// les routes d'affichage
    Route::get('pointeusestransactions/{key}/{val}', [App\Http\Controllers\API\PointeusestransactionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_index2');
    Route::get('pointeusestransactions', [App\Http\Controllers\API\PointeusestransactionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_index');
    Route::post('pointeusestransactions-Aggrid', [App\Http\Controllers\API\PointeusestransactionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_aggrid');

// la route de creation
    Route::post('pointeusestransactions', [App\Http\Controllers\API\PointeusestransactionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_create');
// la route d'edition
    Route::post('pointeusestransactions/{Pointeusestransactions}/update', [App\Http\Controllers\API\PointeusestransactionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_update');
// la route de suppression
    Route::post('pointeusestransactions/{Pointeusestransactions}/delete', [App\Http\Controllers\API\PointeusestransactionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_delete');
// la route des actions
    Route::get('pointeusestransactions/action', [App\Http\Controllers\API\PointeusestransactionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_delete');
// la route des actions
    Route::post('pointeusestransactions/action', [App\Http\Controllers\API\PointeusestransactionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Pointeusestransactions_api_delete');


//Route::resource('Points',App\Http\Controllers\API\PointController::class);
// les routes d'affichage
    Route::get('points/{key}/{val}', [App\Http\Controllers\API\PointController::class, 'data'])->withoutMiddleware("throttle:api")->name('Points_api_index2');
    Route::get('points', [App\Http\Controllers\API\PointController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Points_api_index');
    Route::post('points-Aggrid', [App\Http\Controllers\API\PointController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Points_api_aggrid');

// la route de creation
    Route::post('points', [App\Http\Controllers\API\PointController::class, 'create'])->withoutMiddleware("throttle:api")->name('Points_api_create');
// la route d'edition
    Route::post('points/{Points}/update', [App\Http\Controllers\API\PointController::class, 'update'])->withoutMiddleware("throttle:api")->name('Points_api_update');
// la route de suppression
    Route::post('points/{Points}/delete', [App\Http\Controllers\API\PointController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Points_api_delete');
// la route des actions
    Route::get('points/action', [App\Http\Controllers\API\PointController::class, 'action'])->withoutMiddleware("throttle:api")->name('Points_api_delete');
// la route des actions
    Route::post('points/action', [App\Http\Controllers\API\PointController::class, 'action'])->withoutMiddleware("throttle:api")->name('Points_api_delete');


//Route::resource('Positions',App\Http\Controllers\API\PositionController::class);
// les routes d'affichage
    Route::get('positions/{key}/{val}', [App\Http\Controllers\API\PositionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Positions_api_index2');
    Route::get('positions', [App\Http\Controllers\API\PositionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Positions_api_index');
    Route::post('positions-Aggrid', [App\Http\Controllers\API\PositionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Positions_api_aggrid');

// la route de creation
    Route::post('positions', [App\Http\Controllers\API\PositionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Positions_api_create');
// la route d'edition
    Route::post('positions/{Positions}/update', [App\Http\Controllers\API\PositionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Positions_api_update');
// la route de suppression
    Route::post('positions/{Positions}/delete', [App\Http\Controllers\API\PositionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Positions_api_delete');
// la route des actions
    Route::get('positions/action', [App\Http\Controllers\API\PositionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Positions_api_delete');
// la route des actions
    Route::post('positions/action', [App\Http\Controllers\API\PositionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Positions_api_delete');


//Route::resource('Postes',App\Http\Controllers\API\PosteController::class);
// les routes d'affichage
    Route::get('postes/{key}/{val}', [App\Http\Controllers\API\PosteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Postes_api_index2');
    Route::get('postes', [App\Http\Controllers\API\PosteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Postes_api_index');
    Route::post('postes-Aggrid', [App\Http\Controllers\API\PosteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Postes_api_aggrid');

// la route de creation
    Route::post('postes', [App\Http\Controllers\API\PosteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Postes_api_create');
// la route d'edition
    Route::post('postes/{Postes}/update', [App\Http\Controllers\API\PosteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Postes_api_update');
// la route de suppression
    Route::post('postes/{Postes}/delete', [App\Http\Controllers\API\PosteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Postes_api_delete');
// la route des actions
    Route::get('postes/action', [App\Http\Controllers\API\PosteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postes_api_delete');
// la route des actions
    Route::post('postes/action', [App\Http\Controllers\API\PosteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postes_api_delete');


//Route::resource('Postesagents',App\Http\Controllers\API\PostesagentController::class);
// les routes d'affichage
    Route::get('postesagents/{key}/{val}', [App\Http\Controllers\API\PostesagentController::class, 'data'])->withoutMiddleware("throttle:api")->name('Postesagents_api_index2');
    Route::get('postesagents', [App\Http\Controllers\API\PostesagentController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Postesagents_api_index');
    Route::post('postesagents-Aggrid', [App\Http\Controllers\API\PostesagentController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Postesagents_api_aggrid');

// la route de creation
    Route::post('postesagents', [App\Http\Controllers\API\PostesagentController::class, 'create'])->withoutMiddleware("throttle:api")->name('Postesagents_api_create');
// la route d'edition
    Route::post('postesagents/{Postesagents}/update', [App\Http\Controllers\API\PostesagentController::class, 'update'])->withoutMiddleware("throttle:api")->name('Postesagents_api_update');
// la route de suppression
    Route::post('postesagents/{Postesagents}/delete', [App\Http\Controllers\API\PostesagentController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Postesagents_api_delete');
// la route des actions
    Route::get('postesagents/action', [App\Http\Controllers\API\PostesagentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesagents_api_delete');
// la route des actions
    Route::post('postesagents/action', [App\Http\Controllers\API\PostesagentController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesagents_api_delete');


//Route::resource('Postesarticles',App\Http\Controllers\API\PostesarticleController::class);
// les routes d'affichage
    Route::get('postesarticles/{key}/{val}', [App\Http\Controllers\API\PostesarticleController::class, 'data'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_index2');
    Route::get('postesarticles', [App\Http\Controllers\API\PostesarticleController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_index');
    Route::post('postesarticles-Aggrid', [App\Http\Controllers\API\PostesarticleController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Postesarticles_api_aggrid');

// la route de creation
    Route::post('postesarticles', [App\Http\Controllers\API\PostesarticleController::class, 'create'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_create');
// la route d'edition
    Route::post('postesarticles/{Postesarticles}/update', [App\Http\Controllers\API\PostesarticleController::class, 'update'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_update');
// la route de suppression
    Route::post('postesarticles/{Postesarticles}/delete', [App\Http\Controllers\API\PostesarticleController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_delete');
// la route des actions
    Route::get('postesarticles/action', [App\Http\Controllers\API\PostesarticleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_delete');
// la route des actions
    Route::post('postesarticles/action', [App\Http\Controllers\API\PostesarticleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesarticles_api_delete');


//Route::resource('Postesglobals',App\Http\Controllers\API\PostesglobalController::class);
// les routes d'affichage
    Route::get('postesglobals/{key}/{val}', [App\Http\Controllers\API\PostesglobalController::class, 'data'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_index2');
    Route::get('postesglobals', [App\Http\Controllers\API\PostesglobalController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_index');
    Route::post('postesglobals-Aggrid', [App\Http\Controllers\API\PostesglobalController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Postesglobals_api_aggrid');

// la route de creation
    Route::post('postesglobals', [App\Http\Controllers\API\PostesglobalController::class, 'create'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_create');
// la route d'edition
    Route::post('postesglobals/{Postesglobals}/update', [App\Http\Controllers\API\PostesglobalController::class, 'update'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_update');
// la route de suppression
    Route::post('postesglobals/{Postesglobals}/delete', [App\Http\Controllers\API\PostesglobalController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_delete');
// la route des actions
    Route::get('postesglobals/action', [App\Http\Controllers\API\PostesglobalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_delete');
// la route des actions
    Route::post('postesglobals/action', [App\Http\Controllers\API\PostesglobalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesglobals_api_delete');


//Route::resource('Postesglobals_1',App\Http\Controllers\API\Postesglobal1Controller::class);
// les routes d'affichage
    Route::get('postesglobals_1/{key}/{val}', [App\Http\Controllers\API\Postesglobal1Controller::class, 'data'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_index2');
    Route::get('postesglobals_1', [App\Http\Controllers\API\Postesglobal1Controller::class, 'data1'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_index');
    Route::post('postesglobals_1-Aggrid', [App\Http\Controllers\API\Postesglobal1Controller::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_aggrid');

// la route de creation
    Route::post('postesglobals_1', [App\Http\Controllers\API\Postesglobal1Controller::class, 'create'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_create');
// la route d'edition
    Route::post('postesglobals_1/{Postesglobals_1}/update', [App\Http\Controllers\API\Postesglobal1Controller::class, 'update'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_update');
// la route de suppression
    Route::post('postesglobals_1/{Postesglobals_1}/delete', [App\Http\Controllers\API\Postesglobal1Controller::class, 'delete'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_delete');
// la route des actions
    Route::get('postesglobals_1/action', [App\Http\Controllers\API\Postesglobal1Controller::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_delete');
// la route des actions
    Route::post('postesglobals_1/action', [App\Http\Controllers\API\Postesglobal1Controller::class, 'action'])->withoutMiddleware("throttle:api")->name('Postesglobals_1_api_delete');


//Route::resource('Postespointeuses',App\Http\Controllers\API\PostespointeuseController::class);
// les routes d'affichage
    Route::get('postespointeuses/{key}/{val}', [App\Http\Controllers\API\PostespointeuseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_index2');
    Route::get('postespointeuses', [App\Http\Controllers\API\PostespointeuseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_index');
    Route::post('postespointeuses-Aggrid', [App\Http\Controllers\API\PostespointeuseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Postespointeuses_api_aggrid');

// la route de creation
    Route::post('postespointeuses', [App\Http\Controllers\API\PostespointeuseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_create');
// la route d'edition
    Route::post('postespointeuses/{Postespointeuses}/update', [App\Http\Controllers\API\PostespointeuseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_update');
// la route de suppression
    Route::post('postespointeuses/{Postespointeuses}/delete', [App\Http\Controllers\API\PostespointeuseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_delete');
// la route des actions
    Route::get('postespointeuses/action', [App\Http\Controllers\API\PostespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_delete');
// la route des actions
    Route::post('postespointeuses/action', [App\Http\Controllers\API\PostespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Postespointeuses_api_delete');


//Route::resource('Presences',App\Http\Controllers\API\PresenceController::class);
// les routes d'affichage
    Route::get('presences/{key}/{val}', [App\Http\Controllers\API\PresenceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Presences_api_index2');
    Route::get('presences', [App\Http\Controllers\API\PresenceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Presences_api_index');
    Route::post('presences-Aggrid', [App\Http\Controllers\API\PresenceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Presences_api_aggrid');

// la route de creation
    Route::post('presences', [App\Http\Controllers\API\PresenceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Presences_api_create');
// la route d'edition
    Route::post('presences/{Presences}/update', [App\Http\Controllers\API\PresenceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Presences_api_update');
// la route de suppression
    Route::post('presences/{Presences}/delete', [App\Http\Controllers\API\PresenceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Presences_api_delete');
// la route des actions
    Route::get('presences/action', [App\Http\Controllers\API\PresenceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Presences_api_delete');
// la route des actions
    Route::post('presences/action', [App\Http\Controllers\API\PresenceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Presences_api_delete');


//Route::resource('Prestations',App\Http\Controllers\API\PrestationController::class);
// les routes d'affichage
    Route::get('prestations/{key}/{val}', [App\Http\Controllers\API\PrestationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Prestations_api_index2');
    Route::get('prestations', [App\Http\Controllers\API\PrestationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Prestations_api_index');
    Route::post('prestations-Aggrid', [App\Http\Controllers\API\PrestationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Prestations_api_aggrid');

// la route de creation
    Route::post('prestations', [App\Http\Controllers\API\PrestationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Prestations_api_create');
// la route d'edition
    Route::post('prestations/{Prestations}/update', [App\Http\Controllers\API\PrestationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Prestations_api_update');
// la route de suppression
    Route::post('prestations/{Prestations}/delete', [App\Http\Controllers\API\PrestationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Prestations_api_delete');
// la route des actions
    Route::get('prestations/action', [App\Http\Controllers\API\PrestationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Prestations_api_delete');
// la route des actions
    Route::post('prestations/action', [App\Http\Controllers\API\PrestationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Prestations_api_delete');


//Route::resource('Preuves',App\Http\Controllers\API\PreuveController::class);
// les routes d'affichage
    Route::get('preuves/{key}/{val}', [App\Http\Controllers\API\PreuveController::class, 'data'])->withoutMiddleware("throttle:api")->name('Preuves_api_index2');
    Route::get('preuves', [App\Http\Controllers\API\PreuveController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Preuves_api_index');
    Route::post('preuves-Aggrid', [App\Http\Controllers\API\PreuveController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Preuves_api_aggrid');

// la route de creation
    Route::post('preuves', [App\Http\Controllers\API\PreuveController::class, 'create'])->withoutMiddleware("throttle:api")->name('Preuves_api_create');
// la route d'edition
    Route::post('preuves/{Preuves}/update', [App\Http\Controllers\API\PreuveController::class, 'update'])->withoutMiddleware("throttle:api")->name('Preuves_api_update');
// la route de suppression
    Route::post('preuves/{Preuves}/delete', [App\Http\Controllers\API\PreuveController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Preuves_api_delete');
// la route des actions
    Route::get('preuves/action', [App\Http\Controllers\API\PreuveController::class, 'action'])->withoutMiddleware("throttle:api")->name('Preuves_api_delete');
// la route des actions
    Route::post('preuves/action', [App\Http\Controllers\API\PreuveController::class, 'action'])->withoutMiddleware("throttle:api")->name('Preuves_api_delete');


//Route::resource('Processus',App\Http\Controllers\API\ProcessuController::class);
// les routes d'affichage
    Route::get('processus/{key}/{val}', [App\Http\Controllers\API\ProcessuController::class, 'data'])->withoutMiddleware("throttle:api")->name('Processus_api_index2');
    Route::get('processus', [App\Http\Controllers\API\ProcessuController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Processus_api_index');
    Route::post('processus-Aggrid', [App\Http\Controllers\API\ProcessuController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Processus_api_aggrid');

// la route de creation
    Route::post('processus', [App\Http\Controllers\API\ProcessuController::class, 'create'])->withoutMiddleware("throttle:api")->name('Processus_api_create');
// la route d'edition
    Route::post('processus/{Processus}/update', [App\Http\Controllers\API\ProcessuController::class, 'update'])->withoutMiddleware("throttle:api")->name('Processus_api_update');
// la route de suppression
    Route::post('processus/{Processus}/delete', [App\Http\Controllers\API\ProcessuController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Processus_api_delete');
// la route des actions
    Route::get('processus/action', [App\Http\Controllers\API\ProcessuController::class, 'action'])->withoutMiddleware("throttle:api")->name('Processus_api_delete');
// la route des actions
    Route::post('processus/action', [App\Http\Controllers\API\ProcessuController::class, 'action'])->withoutMiddleware("throttle:api")->name('Processus_api_delete');


//Route::resource('Programmations',App\Http\Controllers\API\ProgrammationController::class);
// les routes d'affichage
    Route::get('programmations/{key}/{val}', [App\Http\Controllers\API\ProgrammationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Programmations_api_index2');
    Route::get('programmations', [App\Http\Controllers\API\ProgrammationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Programmations_api_index');
    Route::post('programmations-Aggrid', [App\Http\Controllers\API\ProgrammationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Programmations_api_aggrid');

// la route de creation
    Route::post('programmations', [App\Http\Controllers\API\ProgrammationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Programmations_api_create');
// la route d'edition
    Route::post('programmations/{Programmations}/update', [App\Http\Controllers\API\ProgrammationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Programmations_api_update');
// la route de suppression
    Route::post('programmations/{Programmations}/delete', [App\Http\Controllers\API\ProgrammationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Programmations_api_delete');
// la route des actions
    Route::get('programmations/action', [App\Http\Controllers\API\ProgrammationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmations_api_delete');
// la route des actions
    Route::post('programmations/action', [App\Http\Controllers\API\ProgrammationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmations_api_delete');


//Route::resource('Programmationsdetails',App\Http\Controllers\API\ProgrammationsdetailController::class);
// les routes d'affichage
    Route::get('programmationsdetails/{key}/{val}', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_index2');
    Route::get('programmationsdetails', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_index');
    Route::post('programmationsdetails-Aggrid', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_aggrid');

// la route de creation
    Route::post('programmationsdetails', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_create');
// la route d'edition
    Route::post('programmationsdetails/{Programmationsdetails}/update', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_update');
// la route de suppression
    Route::post('programmationsdetails/{Programmationsdetails}/delete', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_delete');
// la route des actions
    Route::get('programmationsdetails/action', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_delete');
// la route des actions
    Route::post('programmationsdetails/action', [App\Http\Controllers\API\ProgrammationsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmationsdetails_api_delete');


//Route::resource('Programmationsrondes',App\Http\Controllers\API\ProgrammationsrondeController::class);
// les routes d'affichage
    Route::get('programmationsrondes/{key}/{val}', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_index2');
    Route::get('programmationsrondes', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_index');
    Route::post('programmationsrondes-Aggrid', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_aggrid');

// la route de creation
    Route::post('programmationsrondes', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_create');
// la route d'edition
    Route::post('programmationsrondes/{Programmationsrondes}/update', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_update');
// la route de suppression
    Route::post('programmationsrondes/{Programmationsrondes}/delete', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_delete');
// la route des actions
    Route::get('programmationsrondes/action', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_delete');
// la route des actions
    Route::post('programmationsrondes/action', [App\Http\Controllers\API\ProgrammationsrondeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmationsrondes_api_delete');


//Route::resource('Programmationsusers',App\Http\Controllers\API\ProgrammationsuserController::class);
// les routes d'affichage
    Route::get('programmationsusers/{key}/{val}', [App\Http\Controllers\API\ProgrammationsuserController::class, 'data'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_index2');
    Route::get('programmationsusers', [App\Http\Controllers\API\ProgrammationsuserController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_index');
    Route::post('programmationsusers-Aggrid', [App\Http\Controllers\API\ProgrammationsuserController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Programmationsusers_api_aggrid');

// la route de creation
    Route::post('programmationsusers', [App\Http\Controllers\API\ProgrammationsuserController::class, 'create'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_create');
// la route d'edition
    Route::post('programmationsusers/{Programmationsusers}/update', [App\Http\Controllers\API\ProgrammationsuserController::class, 'update'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_update');
// la route de suppression
    Route::post('programmationsusers/{Programmationsusers}/delete', [App\Http\Controllers\API\ProgrammationsuserController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_delete');
// la route des actions
    Route::get('programmationsusers/action', [App\Http\Controllers\API\ProgrammationsuserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_delete');
// la route des actions
    Route::post('programmationsusers/action', [App\Http\Controllers\API\ProgrammationsuserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmationsusers_api_delete');


//Route::resource('Programmes',App\Http\Controllers\API\ProgrammeController::class);
// les routes d'affichage
    Route::get('programmes/{key}/{val}', [App\Http\Controllers\API\ProgrammeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Programmes_api_index2');
    Route::get('programmes', [App\Http\Controllers\API\ProgrammeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Programmes_api_index');
    Route::post('programmes-Aggrid', [App\Http\Controllers\API\ProgrammeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Programmes_api_aggrid');

// la route de creation
    Route::post('programmes', [App\Http\Controllers\API\ProgrammeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Programmes_api_create');
// la route d'edition
    Route::post('programmes/{Programmes}/update', [App\Http\Controllers\API\ProgrammeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Programmes_api_update');
// la route de suppression
    Route::post('programmes/{Programmes}/delete', [App\Http\Controllers\API\ProgrammeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Programmes_api_delete');
// la route des actions
    Route::get('programmes/action', [App\Http\Controllers\API\ProgrammeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmes_api_delete');
// la route des actions
    Route::post('programmes/action', [App\Http\Controllers\API\ProgrammeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmes_api_delete');


//Route::resource('Programmesrondes',App\Http\Controllers\API\ProgrammesrondeController::class);
// les routes d'affichage
    Route::get('programmesrondes/{key}/{val}', [App\Http\Controllers\API\ProgrammesrondeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_index2');
    Route::get('programmesrondes', [App\Http\Controllers\API\ProgrammesrondeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_index');
    Route::post('programmesrondes-Aggrid', [App\Http\Controllers\API\ProgrammesrondeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Programmesrondes_api_aggrid');

// la route de creation
    Route::post('programmesrondes', [App\Http\Controllers\API\ProgrammesrondeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_create');
// la route d'edition
    Route::post('programmesrondes/{Programmesrondes}/update', [App\Http\Controllers\API\ProgrammesrondeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_update');
// la route de suppression
    Route::post('programmesrondes/{Programmesrondes}/delete', [App\Http\Controllers\API\ProgrammesrondeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_delete');
// la route des actions
    Route::get('programmesrondes/action', [App\Http\Controllers\API\ProgrammesrondeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_delete');
// la route des actions
    Route::post('programmesrondes/action', [App\Http\Controllers\API\ProgrammesrondeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Programmesrondes_api_delete');


//Route::resource('Projets',App\Http\Controllers\API\ProjetController::class);
// les routes d'affichage
    Route::get('projets/{key}/{val}', [App\Http\Controllers\API\ProjetController::class, 'data'])->withoutMiddleware("throttle:api")->name('Projets_api_index2');
    Route::get('projets', [App\Http\Controllers\API\ProjetController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Projets_api_index');
    Route::post('projets-Aggrid', [App\Http\Controllers\API\ProjetController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Projets_api_aggrid');

// la route de creation
    Route::post('projets', [App\Http\Controllers\API\ProjetController::class, 'create'])->withoutMiddleware("throttle:api")->name('Projets_api_create');
// la route d'edition
    Route::post('projets/{Projets}/update', [App\Http\Controllers\API\ProjetController::class, 'update'])->withoutMiddleware("throttle:api")->name('Projets_api_update');
// la route de suppression
    Route::post('projets/{Projets}/delete', [App\Http\Controllers\API\ProjetController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Projets_api_delete');
// la route des actions
    Route::get('projets/action', [App\Http\Controllers\API\ProjetController::class, 'action'])->withoutMiddleware("throttle:api")->name('Projets_api_delete');
// la route des actions
    Route::post('projets/action', [App\Http\Controllers\API\ProjetController::class, 'action'])->withoutMiddleware("throttle:api")->name('Projets_api_delete');


//Route::resource('Provinces',App\Http\Controllers\API\ProvinceController::class);
// les routes d'affichage
    Route::get('provinces/{key}/{val}', [App\Http\Controllers\API\ProvinceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Provinces_api_index2');
    Route::get('provinces', [App\Http\Controllers\API\ProvinceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Provinces_api_index');
    Route::post('provinces-Aggrid', [App\Http\Controllers\API\ProvinceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Provinces_api_aggrid');

// la route de creation
    Route::post('provinces', [App\Http\Controllers\API\ProvinceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Provinces_api_create');
// la route d'edition
    Route::post('provinces/{Provinces}/update', [App\Http\Controllers\API\ProvinceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Provinces_api_update');
// la route de suppression
    Route::post('provinces/{Provinces}/delete', [App\Http\Controllers\API\ProvinceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Provinces_api_delete');
// la route des actions
    Route::get('provinces/action', [App\Http\Controllers\API\ProvinceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Provinces_api_delete');
// la route des actions
    Route::post('provinces/action', [App\Http\Controllers\API\ProvinceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Provinces_api_delete');


//Route::resource('Rapportpostes',App\Http\Controllers\API\RapportposteController::class);
// les routes d'affichage
    Route::get('rapportpostes/{key}/{val}', [App\Http\Controllers\API\RapportposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_index2');
    Route::get('rapportpostes', [App\Http\Controllers\API\RapportposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_index');
    Route::post('rapportpostes-Aggrid', [App\Http\Controllers\API\RapportposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Rapportpostes_api_aggrid');

// la route de creation
    Route::post('rapportpostes', [App\Http\Controllers\API\RapportposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_create');
// la route d'edition
    Route::post('rapportpostes/{Rapportpostes}/update', [App\Http\Controllers\API\RapportposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_update');
// la route de suppression
    Route::post('rapportpostes/{Rapportpostes}/delete', [App\Http\Controllers\API\RapportposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_delete');
// la route des actions
    Route::get('rapportpostes/action', [App\Http\Controllers\API\RapportposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_delete');
// la route des actions
    Route::post('rapportpostes/action', [App\Http\Controllers\API\RapportposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Rapportpostes_api_delete');


//Route::resource('Rapports',App\Http\Controllers\API\RapportController::class);
// les routes d'affichage
    Route::get('rapports/{key}/{val}', [App\Http\Controllers\API\RapportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Rapports_api_index2');
    Route::get('rapports', [App\Http\Controllers\API\RapportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Rapports_api_index');
    Route::post('rapports-Aggrid', [App\Http\Controllers\API\RapportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Rapports_api_aggrid');

// la route de creation
    Route::post('rapports', [App\Http\Controllers\API\RapportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Rapports_api_create');
// la route d'edition
    Route::post('rapports/{Rapports}/update', [App\Http\Controllers\API\RapportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Rapports_api_update');
// la route de suppression
    Route::post('rapports/{Rapports}/delete', [App\Http\Controllers\API\RapportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Rapports_api_delete');
// la route des actions
    Route::get('rapports/action', [App\Http\Controllers\API\RapportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Rapports_api_delete');
// la route des actions
    Route::post('rapports/action', [App\Http\Controllers\API\RapportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Rapports_api_delete');


//Route::resource('Recuperes',App\Http\Controllers\API\RecupereController::class);
// les routes d'affichage
    Route::get('recuperes/{key}/{val}', [App\Http\Controllers\API\RecupereController::class, 'data'])->withoutMiddleware("throttle:api")->name('Recuperes_api_index2');
    Route::get('recuperes', [App\Http\Controllers\API\RecupereController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Recuperes_api_index');
    Route::post('recuperes-Aggrid', [App\Http\Controllers\API\RecupereController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Recuperes_api_aggrid');

// la route de creation
    Route::post('recuperes', [App\Http\Controllers\API\RecupereController::class, 'create'])->withoutMiddleware("throttle:api")->name('Recuperes_api_create');
// la route d'edition
    Route::post('recuperes/{Recuperes}/update', [App\Http\Controllers\API\RecupereController::class, 'update'])->withoutMiddleware("throttle:api")->name('Recuperes_api_update');
// la route de suppression
    Route::post('recuperes/{Recuperes}/delete', [App\Http\Controllers\API\RecupereController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Recuperes_api_delete');
// la route des actions
    Route::get('recuperes/action', [App\Http\Controllers\API\RecupereController::class, 'action'])->withoutMiddleware("throttle:api")->name('Recuperes_api_delete');
// la route des actions
    Route::post('recuperes/action', [App\Http\Controllers\API\RecupereController::class, 'action'])->withoutMiddleware("throttle:api")->name('Recuperes_api_delete');


//Route::resource('Ressources',App\Http\Controllers\API\RessourceController::class);
// les routes d'affichage
    Route::get('ressources/{key}/{val}', [App\Http\Controllers\API\RessourceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Ressources_api_index2');
    Route::get('ressources', [App\Http\Controllers\API\RessourceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Ressources_api_index');
    Route::post('ressources-Aggrid', [App\Http\Controllers\API\RessourceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Ressources_api_aggrid');

// la route de creation
    Route::post('ressources', [App\Http\Controllers\API\RessourceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Ressources_api_create');
// la route d'edition
    Route::post('ressources/{Ressources}/update', [App\Http\Controllers\API\RessourceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Ressources_api_update');
// la route de suppression
    Route::post('ressources/{Ressources}/delete', [App\Http\Controllers\API\RessourceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Ressources_api_delete');
// la route des actions
    Route::get('ressources/action', [App\Http\Controllers\API\RessourceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Ressources_api_delete');
// la route des actions
    Route::post('ressources/action', [App\Http\Controllers\API\RessourceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Ressources_api_delete');


//Route::resource('Role_has_permission',App\Http\Controllers\API\RoleHasPermisionController::class);
// les routes d'affichage
    Route::get('role_has_permission/{key}/{val}', [App\Http\Controllers\API\RoleHasPermisionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_index2');
    Route::get('role_has_permission', [App\Http\Controllers\API\RoleHasPermisionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_index');
    Route::post('role_has_permission-Aggrid', [App\Http\Controllers\API\RoleHasPermisionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Role_has_permission_api_aggrid');

// la route de creation
    Route::post('role_has_permission', [App\Http\Controllers\API\RoleHasPermisionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_create');
// la route d'edition
    Route::post('role_has_permission/{Role_has_permission}/update', [App\Http\Controllers\API\RoleHasPermisionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_update');
// la route de suppression
    Route::post('role_has_permission/{Role_has_permission}/delete', [App\Http\Controllers\API\RoleHasPermisionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_delete');
// la route des actions
    Route::get('role_has_permission/action', [App\Http\Controllers\API\RoleHasPermisionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_delete');
// la route des actions
    Route::post('role_has_permission/action', [App\Http\Controllers\API\RoleHasPermisionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Role_has_permission_api_delete');


//Route::resource('Role_has_permissions',App\Http\Controllers\API\RoleHasPermissionController::class);
// les routes d'affichage
    Route::get('roleHasPermission/{key}/{val}', [App\Http\Controllers\API\RoleHasPermissionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_index2');
    Route::get('roleHasPermission', [App\Http\Controllers\API\RoleHasPermissionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_index');
    Route::post('roleHasPermission-Aggrid', [App\Http\Controllers\API\RoleHasPermissionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_aggrid');

// la route de creation
    Route::post('roleHasPermission', [App\Http\Controllers\API\RoleHasPermissionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_create');
// la route d'edition
    Route::post('roleHasPermission/{Role_has_permissions}/update', [App\Http\Controllers\API\RoleHasPermissionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_update');
// la route de suppression
    Route::post('roleHasPermission/{Role_has_permissions}/delete', [App\Http\Controllers\API\RoleHasPermissionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_delete');
// la route des actions
    Route::get('roleHasPermission/action', [App\Http\Controllers\API\RoleHasPermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_delete');
// la route des actions
    Route::post('roleHasPermission/action', [App\Http\Controllers\API\RoleHasPermissionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Role_has_permissions_api_delete');


//Route::resource('Roles',App\Http\Controllers\API\RoleController::class);
// les routes d'affichage
    Route::get('roles/{key}/{val}', [App\Http\Controllers\API\RoleController::class, 'data'])->withoutMiddleware("throttle:api")->name('Roles_api_index2');
    Route::get('roles', [App\Http\Controllers\API\RoleController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Roles_api_index');
    Route::post('roles-Aggrid', [App\Http\Controllers\API\RoleController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Roles_api_aggrid');

// la route de creation
    Route::post('roles', [App\Http\Controllers\API\RoleController::class, 'create'])->withoutMiddleware("throttle:api")->name('Roles_api_create');
// la route d'edition
    Route::post('roles/{Roles}/update', [App\Http\Controllers\API\RoleController::class, 'update'])->withoutMiddleware("throttle:api")->name('Roles_api_update');
// la route de suppression
    Route::post('roles/{Roles}/delete', [App\Http\Controllers\API\RoleController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Roles_api_delete');
// la route des actions
    Route::get('roles/action', [App\Http\Controllers\API\RoleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Roles_api_delete');
// la route des actions
    Route::post('roles/action', [App\Http\Controllers\API\RoleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Roles_api_delete');


//Route::resource('Services',App\Http\Controllers\API\ServiceController::class);
// les routes d'affichage
    Route::get('services/{key}/{val}', [App\Http\Controllers\API\ServiceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Services_api_index2');
    Route::get('services', [App\Http\Controllers\API\ServiceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Services_api_index');
    Route::post('services-Aggrid', [App\Http\Controllers\API\ServiceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Services_api_aggrid');

// la route de creation
    Route::post('services', [App\Http\Controllers\API\ServiceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Services_api_create');
// la route d'edition
    Route::post('services/{Services}/update', [App\Http\Controllers\API\ServiceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Services_api_update');
// la route de suppression
    Route::post('services/{Services}/delete', [App\Http\Controllers\API\ServiceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Services_api_delete');
// la route des actions
    Route::get('services/action', [App\Http\Controllers\API\ServiceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Services_api_delete');
// la route des actions
    Route::post('services/action', [App\Http\Controllers\API\ServiceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Services_api_delete');


//Route::resource('Sexes',App\Http\Controllers\API\SexeController::class);
// les routes d'affichage
    Route::get('sexes/{key}/{val}', [App\Http\Controllers\API\SexeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Sexes_api_index2');
    Route::get('sexes', [App\Http\Controllers\API\SexeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Sexes_api_index');
    Route::post('sexes-Aggrid', [App\Http\Controllers\API\SexeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Sexes_api_aggrid');

// la route de creation
    Route::post('sexes', [App\Http\Controllers\API\SexeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Sexes_api_create');
// la route d'edition
    Route::post('sexes/{Sexes}/update', [App\Http\Controllers\API\SexeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Sexes_api_update');
// la route de suppression
    Route::post('sexes/{Sexes}/delete', [App\Http\Controllers\API\SexeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Sexes_api_delete');
// la route des actions
    Route::get('sexes/action', [App\Http\Controllers\API\SexeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sexes_api_delete');
// la route des actions
    Route::post('sexes/action', [App\Http\Controllers\API\SexeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sexes_api_delete');


//Route::resource('Sites',App\Http\Controllers\API\SiteController::class);
// les routes d'affichage
    Route::get('sites/{key}/{val}', [App\Http\Controllers\API\SiteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Sites_api_index2');
    Route::get('sites', [App\Http\Controllers\API\SiteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Sites_api_index');
    Route::post('sites-Aggrid', [App\Http\Controllers\API\SiteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Sites_api_aggrid');

// la route de creation
    Route::post('sites', [App\Http\Controllers\API\SiteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Sites_api_create');
// la route d'edition
    Route::post('sites/{Sites}/update', [App\Http\Controllers\API\SiteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Sites_api_update');
// la route de suppression
    Route::post('sites/{Sites}/delete', [App\Http\Controllers\API\SiteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Sites_api_delete');
// la route des actions
    Route::get('sites/action', [App\Http\Controllers\API\SiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sites_api_delete');
// la route des actions
    Route::post('sites/action', [App\Http\Controllers\API\SiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sites_api_delete');


//Route::resource('Sitesglobals',App\Http\Controllers\API\SitesglobalController::class);
// les routes d'affichage
    Route::get('sitesglobals/{key}/{val}', [App\Http\Controllers\API\SitesglobalController::class, 'data'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_index2');
    Route::get('sitesglobals', [App\Http\Controllers\API\SitesglobalController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_index');
    Route::post('sitesglobals-Aggrid', [App\Http\Controllers\API\SitesglobalController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Sitesglobals_api_aggrid');

// la route de creation
    Route::post('sitesglobals', [App\Http\Controllers\API\SitesglobalController::class, 'create'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_create');
// la route d'edition
    Route::post('sitesglobals/{Sitesglobals}/update', [App\Http\Controllers\API\SitesglobalController::class, 'update'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_update');
// la route de suppression
    Route::post('sitesglobals/{Sitesglobals}/delete', [App\Http\Controllers\API\SitesglobalController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_delete');
// la route des actions
    Route::get('sitesglobals/action', [App\Http\Controllers\API\SitesglobalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_delete');
// la route des actions
    Route::post('sitesglobals/action', [App\Http\Controllers\API\SitesglobalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sitesglobals_api_delete');


//Route::resource('Sitespointeuses',App\Http\Controllers\API\SitespointeuseController::class);
// les routes d'affichage
    Route::get('sitespointeuses/{key}/{val}', [App\Http\Controllers\API\SitespointeuseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_index2');
    Route::get('sitespointeuses', [App\Http\Controllers\API\SitespointeuseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_index');
    Route::post('sitespointeuses-Aggrid', [App\Http\Controllers\API\SitespointeuseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_aggrid');

// la route de creation
    Route::post('sitespointeuses', [App\Http\Controllers\API\SitespointeuseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_create');
// la route d'edition
    Route::post('sitespointeuses/{Sitespointeuses}/update', [App\Http\Controllers\API\SitespointeuseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_update');
// la route de suppression
    Route::post('sitespointeuses/{Sitespointeuses}/delete', [App\Http\Controllers\API\SitespointeuseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_delete');
// la route des actions
    Route::get('sitespointeuses/action', [App\Http\Controllers\API\SitespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_delete');
// la route des actions
    Route::post('sitespointeuses/action', [App\Http\Controllers\API\SitespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sitespointeuses_api_delete');


//Route::resource('Sitessdeplacements',App\Http\Controllers\API\SitessdeplacementController::class);
// les routes d'affichage
    Route::get('sitessdeplacements/{key}/{val}', [App\Http\Controllers\API\SitessdeplacementController::class, 'data'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_index2');
    Route::get('sitessdeplacements', [App\Http\Controllers\API\SitessdeplacementController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_index');
    Route::post('sitessdeplacements-Aggrid', [App\Http\Controllers\API\SitessdeplacementController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_aggrid');

// la route de creation
    Route::post('sitessdeplacements', [App\Http\Controllers\API\SitessdeplacementController::class, 'create'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_create');
// la route d'edition
    Route::post('sitessdeplacements/{Sitessdeplacements}/update', [App\Http\Controllers\API\SitessdeplacementController::class, 'update'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_update');
// la route de suppression
    Route::post('sitessdeplacements/{Sitessdeplacements}/delete', [App\Http\Controllers\API\SitessdeplacementController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_delete');
// la route des actions
    Route::get('sitessdeplacements/action', [App\Http\Controllers\API\SitessdeplacementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_delete');
// la route des actions
    Route::post('sitessdeplacements/action', [App\Http\Controllers\API\SitessdeplacementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Sitessdeplacements_api_delete');


//Route::resource('Situations',App\Http\Controllers\API\SituationController::class);
// les routes d'affichage
    Route::get('situations/{key}/{val}', [App\Http\Controllers\API\SituationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Situations_api_index2');
    Route::get('situations', [App\Http\Controllers\API\SituationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Situations_api_index');
    Route::post('situations-Aggrid', [App\Http\Controllers\API\SituationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Situations_api_aggrid');

// la route de creation
    Route::post('situations', [App\Http\Controllers\API\SituationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Situations_api_create');
// la route d'edition
    Route::post('situations/{Situations}/update', [App\Http\Controllers\API\SituationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Situations_api_update');
// la route de suppression
    Route::post('situations/{Situations}/delete', [App\Http\Controllers\API\SituationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Situations_api_delete');
// la route des actions
    Route::get('situations/action', [App\Http\Controllers\API\SituationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Situations_api_delete');
// la route des actions
    Route::post('situations/action', [App\Http\Controllers\API\SituationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Situations_api_delete');


//Route::resource('Soldables',App\Http\Controllers\API\SoldableController::class);
// les routes d'affichage
    Route::get('soldables/{key}/{val}', [App\Http\Controllers\API\SoldableController::class, 'data'])->withoutMiddleware("throttle:api")->name('Soldables_api_index2');
    Route::get('soldables', [App\Http\Controllers\API\SoldableController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Soldables_api_index');
    Route::post('soldables-Aggrid', [App\Http\Controllers\API\SoldableController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Soldables_api_aggrid');

// la route de creation
    Route::post('soldables', [App\Http\Controllers\API\SoldableController::class, 'create'])->withoutMiddleware("throttle:api")->name('Soldables_api_create');
// la route d'edition
    Route::post('soldables/{Soldables}/update', [App\Http\Controllers\API\SoldableController::class, 'update'])->withoutMiddleware("throttle:api")->name('Soldables_api_update');
// la route de suppression
    Route::post('soldables/{Soldables}/delete', [App\Http\Controllers\API\SoldableController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Soldables_api_delete');
// la route des actions
    Route::get('soldables/action', [App\Http\Controllers\API\SoldableController::class, 'action'])->withoutMiddleware("throttle:api")->name('Soldables_api_delete');
// la route des actions
    Route::post('soldables/action', [App\Http\Controllers\API\SoldableController::class, 'action'])->withoutMiddleware("throttle:api")->name('Soldables_api_delete');


//Route::resource('Statszones',App\Http\Controllers\API\StatszoneController::class);
// les routes d'affichage
    Route::get('statszones/{key}/{val}', [App\Http\Controllers\API\StatszoneController::class, 'data'])->withoutMiddleware("throttle:api")->name('Statszones_api_index2');
    Route::get('statszones', [App\Http\Controllers\API\StatszoneController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Statszones_api_index');
    Route::post('statszones-Aggrid', [App\Http\Controllers\API\StatszoneController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Statszones_api_aggrid');

// la route de creation
    Route::post('statszones', [App\Http\Controllers\API\StatszoneController::class, 'create'])->withoutMiddleware("throttle:api")->name('Statszones_api_create');
// la route d'edition
    Route::post('statszones/{Statszones}/update', [App\Http\Controllers\API\StatszoneController::class, 'update'])->withoutMiddleware("throttle:api")->name('Statszones_api_update');
// la route de suppression
    Route::post('statszones/{Statszones}/delete', [App\Http\Controllers\API\StatszoneController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Statszones_api_delete');
// la route des actions
    Route::get('statszones/action', [App\Http\Controllers\API\StatszoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Statszones_api_delete');
// la route des actions
    Route::post('statszones/action', [App\Http\Controllers\API\StatszoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Statszones_api_delete');


//Route::resource('Supervirzclients',App\Http\Controllers\API\SupervirzclientController::class);
// les routes d'affichage
    Route::get('supervirzclients/{key}/{val}', [App\Http\Controllers\API\SupervirzclientController::class, 'data'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_index2');
    Route::get('supervirzclients', [App\Http\Controllers\API\SupervirzclientController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_index');
    Route::post('supervirzclients-Aggrid', [App\Http\Controllers\API\SupervirzclientController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Supervirzclients_api_aggrid');

// la route de creation
    Route::post('supervirzclients', [App\Http\Controllers\API\SupervirzclientController::class, 'create'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_create');
// la route d'edition
    Route::post('supervirzclients/{Supervirzclients}/update', [App\Http\Controllers\API\SupervirzclientController::class, 'update'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_update');
// la route de suppression
    Route::post('supervirzclients/{Supervirzclients}/delete', [App\Http\Controllers\API\SupervirzclientController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_delete');
// la route des actions
    Route::get('supervirzclients/action', [App\Http\Controllers\API\SupervirzclientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_delete');
// la route des actions
    Route::post('supervirzclients/action', [App\Http\Controllers\API\SupervirzclientController::class, 'action'])->withoutMiddleware("throttle:api")->name('Supervirzclients_api_delete');


//Route::resource('Supervirzclientshides',App\Http\Controllers\API\SupervirzclientshideController::class);
// les routes d'affichage
    Route::get('supervirzclientshides/{key}/{val}', [App\Http\Controllers\API\SupervirzclientshideController::class, 'data'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_index2');
    Route::get('supervirzclientshides', [App\Http\Controllers\API\SupervirzclientshideController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_index');
    Route::post('supervirzclientshides-Aggrid', [App\Http\Controllers\API\SupervirzclientshideController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_aggrid');

// la route de creation
    Route::post('supervirzclientshides', [App\Http\Controllers\API\SupervirzclientshideController::class, 'create'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_create');
// la route d'edition
    Route::post('supervirzclientshides/{Supervirzclientshides}/update', [App\Http\Controllers\API\SupervirzclientshideController::class, 'update'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_update');
// la route de suppression
    Route::post('supervirzclientshides/{Supervirzclientshides}/delete', [App\Http\Controllers\API\SupervirzclientshideController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_delete');
// la route des actions
    Route::get('supervirzclientshides/action', [App\Http\Controllers\API\SupervirzclientshideController::class, 'action'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_delete');
// la route des actions
    Route::post('supervirzclientshides/action', [App\Http\Controllers\API\SupervirzclientshideController::class, 'action'])->withoutMiddleware("throttle:api")->name('Supervirzclientshides_api_delete');


//Route::resource('Surveillances',App\Http\Controllers\API\SurveillanceController::class);
// les routes d'affichage
    Route::get('surveillances/{key}/{val}', [App\Http\Controllers\API\SurveillanceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Surveillances_api_index2');
    Route::get('surveillances', [App\Http\Controllers\API\SurveillanceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Surveillances_api_index');
    Route::post('surveillances-Aggrid', [App\Http\Controllers\API\SurveillanceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Surveillances_api_aggrid');

// la route de creation
    Route::post('surveillances', [App\Http\Controllers\API\SurveillanceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Surveillances_api_create');
// la route d'edition
    Route::post('surveillances/{Surveillances}/update', [App\Http\Controllers\API\SurveillanceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Surveillances_api_update');
// la route de suppression
    Route::post('surveillances/{Surveillances}/delete', [App\Http\Controllers\API\SurveillanceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Surveillances_api_delete');
// la route des actions
    Route::get('surveillances/action', [App\Http\Controllers\API\SurveillanceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Surveillances_api_delete');
// la route des actions
    Route::post('surveillances/action', [App\Http\Controllers\API\SurveillanceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Surveillances_api_delete');


//Route::resource('Switchsusers',App\Http\Controllers\API\SwitchsuserController::class);
// les routes d'affichage
    Route::get('switchsusers/{key}/{val}', [App\Http\Controllers\API\SwitchsuserController::class, 'data'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_index2');
    Route::get('switchsusers', [App\Http\Controllers\API\SwitchsuserController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_index');
    Route::post('switchsusers-Aggrid', [App\Http\Controllers\API\SwitchsuserController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Switchsusers_api_aggrid');

// la route de creation
    Route::post('switchsusers', [App\Http\Controllers\API\SwitchsuserController::class, 'create'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_create');
// la route d'edition
    Route::post('switchsusers/{Switchsusers}/update', [App\Http\Controllers\API\SwitchsuserController::class, 'update'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_update');
// la route de suppression
    Route::post('switchsusers/{Switchsusers}/delete', [App\Http\Controllers\API\SwitchsuserController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_delete');
// la route des actions
    Route::get('switchsusers/action', [App\Http\Controllers\API\SwitchsuserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_delete');
// la route des actions
    Route::post('switchsusers/action', [App\Http\Controllers\API\SwitchsuserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Switchsusers_api_delete');


//Route::resource('Taches',App\Http\Controllers\API\TacheController::class);
// les routes d'affichage
    Route::get('taches/{key}/{val}', [App\Http\Controllers\API\TacheController::class, 'data'])->withoutMiddleware("throttle:api")->name('Taches_api_index2');
    Route::get('taches', [App\Http\Controllers\API\TacheController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Taches_api_index');
    Route::post('taches-Aggrid', [App\Http\Controllers\API\TacheController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Taches_api_aggrid');

// la route de creation
    Route::post('taches', [App\Http\Controllers\API\TacheController::class, 'create'])->withoutMiddleware("throttle:api")->name('Taches_api_create');
// la route d'edition
    Route::post('taches/{Taches}/update', [App\Http\Controllers\API\TacheController::class, 'update'])->withoutMiddleware("throttle:api")->name('Taches_api_update');
// la route de suppression
    Route::post('taches/{Taches}/delete', [App\Http\Controllers\API\TacheController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Taches_api_delete');
// la route des actions
    Route::get('taches/action', [App\Http\Controllers\API\TacheController::class, 'action'])->withoutMiddleware("throttle:api")->name('Taches_api_delete');
// la route des actions
    Route::post('taches/action', [App\Http\Controllers\API\TacheController::class, 'action'])->withoutMiddleware("throttle:api")->name('Taches_api_delete');


//Route::resource('Tachespointeuses',App\Http\Controllers\API\TachespointeuseController::class);
// les routes d'affichage
    Route::get('tachespointeuses/{key}/{val}', [App\Http\Controllers\API\TachespointeuseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_index2');
    Route::get('tachespointeuses', [App\Http\Controllers\API\TachespointeuseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_index');
    Route::post('tachespointeuses-Aggrid', [App\Http\Controllers\API\TachespointeuseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_aggrid');

// la route de creation
    Route::post('tachespointeuses', [App\Http\Controllers\API\TachespointeuseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_create');
// la route d'edition
    Route::post('tachespointeuses/{Tachespointeuses}/update', [App\Http\Controllers\API\TachespointeuseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_update');
// la route de suppression
    Route::post('tachespointeuses/{Tachespointeuses}/delete', [App\Http\Controllers\API\TachespointeuseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_delete');
// la route des actions
    Route::get('tachespointeuses/action', [App\Http\Controllers\API\TachespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_delete');
// la route des actions
    Route::post('tachespointeuses/action', [App\Http\Controllers\API\TachespointeuseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Tachespointeuses_api_delete');


//Route::resource('Terminals',App\Http\Controllers\API\TerminalController::class);
// les routes d'affichage
    Route::get('terminals/{key}/{val}', [App\Http\Controllers\API\TerminalController::class, 'data'])->withoutMiddleware("throttle:api")->name('Terminals_api_index2');
    Route::get('terminals', [App\Http\Controllers\API\TerminalController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Terminals_api_index');
    Route::post('terminals-Aggrid', [App\Http\Controllers\API\TerminalController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Terminals_api_aggrid');

// la route de creation
    Route::post('terminals', [App\Http\Controllers\API\TerminalController::class, 'create'])->withoutMiddleware("throttle:api")->name('Terminals_api_create');
// la route d'edition
    Route::post('terminals/{Terminals}/update', [App\Http\Controllers\API\TerminalController::class, 'update'])->withoutMiddleware("throttle:api")->name('Terminals_api_update');
// la route de suppression
    Route::post('terminals/{Terminals}/delete', [App\Http\Controllers\API\TerminalController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Terminals_api_delete');
// la route des actions
    Route::get('terminals/action', [App\Http\Controllers\API\TerminalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Terminals_api_delete');
// la route des actions
    Route::post('terminals/action', [App\Http\Controllers\API\TerminalController::class, 'action'])->withoutMiddleware("throttle:api")->name('Terminals_api_delete');


//Route::resource('Trackings',App\Http\Controllers\API\TrackingController::class);
// les routes d'affichage
    Route::get('trackings/{key}/{val}', [App\Http\Controllers\API\TrackingController::class, 'data'])->withoutMiddleware("throttle:api")->name('Trackings_api_index2');
    Route::get('trackings', [App\Http\Controllers\API\TrackingController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Trackings_api_index');
    Route::post('trackings-Aggrid', [App\Http\Controllers\API\TrackingController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Trackings_api_aggrid');

// la route de creation
    Route::post('trackings', [App\Http\Controllers\API\TrackingController::class, 'create'])->withoutMiddleware("throttle:api")->name('Trackings_api_create');
// la route d'edition
    Route::post('trackings/{Trackings}/update', [App\Http\Controllers\API\TrackingController::class, 'update'])->withoutMiddleware("throttle:api")->name('Trackings_api_update');
// la route de suppression
    Route::post('trackings/{Trackings}/delete', [App\Http\Controllers\API\TrackingController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Trackings_api_delete');
// la route des actions
    Route::get('trackings/action', [App\Http\Controllers\API\TrackingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Trackings_api_delete');
// la route des actions
    Route::post('trackings/action', [App\Http\Controllers\API\TrackingController::class, 'action'])->withoutMiddleware("throttle:api")->name('Trackings_api_delete');


//Route::resource('Trajets',App\Http\Controllers\API\TrajetController::class);
// les routes d'affichage
    Route::get('trajets/{key}/{val}', [App\Http\Controllers\API\TrajetController::class, 'data'])->withoutMiddleware("throttle:api")->name('Trajets_api_index2');
    Route::get('trajets', [App\Http\Controllers\API\TrajetController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Trajets_api_index');
    Route::post('trajets-Aggrid', [App\Http\Controllers\API\TrajetController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Trajets_api_aggrid');

// la route de creation
    Route::post('trajets', [App\Http\Controllers\API\TrajetController::class, 'create'])->withoutMiddleware("throttle:api")->name('Trajets_api_create');
// la route d'edition
    Route::post('trajets/{Trajets}/update', [App\Http\Controllers\API\TrajetController::class, 'update'])->withoutMiddleware("throttle:api")->name('Trajets_api_update');
// la route de suppression
    Route::post('trajets/{Trajets}/delete', [App\Http\Controllers\API\TrajetController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Trajets_api_delete');
// la route des actions
    Route::get('trajets/action', [App\Http\Controllers\API\TrajetController::class, 'action'])->withoutMiddleware("throttle:api")->name('Trajets_api_delete');
// la route des actions
    Route::post('trajets/action', [App\Http\Controllers\API\TrajetController::class, 'action'])->withoutMiddleware("throttle:api")->name('Trajets_api_delete');


//Route::resource('Transactionhistoriques',App\Http\Controllers\API\TransactionhistoriqueController::class);
// les routes d'affichage
    Route::get('transactionhistoriques/{key}/{val}', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_index2');
    Route::get('transactionhistoriques', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_index');
    Route::post('transactionhistoriques-Aggrid', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_aggrid');

// la route de creation
    Route::post('transactionhistoriques', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_create');
// la route d'edition
    Route::post('transactionhistoriques/{Transactionhistoriques}/update', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_update');
// la route de suppression
    Route::post('transactionhistoriques/{Transactionhistoriques}/delete', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_delete');
// la route des actions
    Route::get('transactionhistoriques/action', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_delete');
// la route des actions
    Route::post('transactionhistoriques/action', [App\Http\Controllers\API\TransactionhistoriqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionhistoriques_api_delete');


//Route::resource('Transactions',App\Http\Controllers\API\TransactionController::class);
// les routes d'affichage
    Route::get('transactions/{key}/{val}', [App\Http\Controllers\API\TransactionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactions_api_index2');
    Route::get('transactions', [App\Http\Controllers\API\TransactionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactions_api_index');
    Route::post('transactions-Aggrid', [App\Http\Controllers\API\TransactionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactions_api_aggrid');

// la route de creation
    Route::post('transactions', [App\Http\Controllers\API\TransactionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactions_api_create');
// la route d'edition
    Route::post('transactions/{Transactions}/update', [App\Http\Controllers\API\TransactionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactions_api_update');
// la route de suppression
    Route::post('transactions/{Transactions}/delete', [App\Http\Controllers\API\TransactionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactions_api_delete');
// la route des actions
    Route::get('transactions/action', [App\Http\Controllers\API\TransactionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactions_api_delete');
// la route des actions
    Route::post('transactions/action', [App\Http\Controllers\API\TransactionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactions_api_delete');

//Route::resource('Transactionsdetails',App\Http\Controllers\API\TransactionsdetailController::class);
// les routes d'affichage
Route::get('transactionsdetails/{key}/{val}', [App\Http\Controllers\API\TransactionsdetailController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_index2');
Route::get('transactionsdetails', [App\Http\Controllers\API\TransactionsdetailController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_index');
Route::post('transactionsdetails-Aggrid', [App\Http\Controllers\API\TransactionsdetailController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_aggrid');

// la route de creation
Route::post('transactionsdetails', [App\Http\Controllers\API\TransactionsdetailController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_create');
// la route d'edition
Route::post('transactionsdetails/{Transactionsdetails}/update', [App\Http\Controllers\API\TransactionsdetailController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_update');
// la route de suppression
Route::post('transactionsdetails/{Transactionsdetails}/delete', [App\Http\Controllers\API\TransactionsdetailController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_delete');
// la route des actions
Route::get('transactionsdetails/action', [App\Http\Controllers\API\TransactionsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_delete');
// la route des actions
Route::post('transactionsdetails/action', [App\Http\Controllers\API\TransactionsdetailController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsdetails_api_delete');


//Route::resource('Traitements',App\Http\Controllers\API\TraitementController::class);
// les routes d'affichage
    Route::get('traitements/{key}/{val}', [App\Http\Controllers\API\TraitementController::class, 'data'])->withoutMiddleware("throttle:api")->name('Traitements_api_index2');
    Route::get('traitements', [App\Http\Controllers\API\TraitementController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Traitements_api_index');
    Route::post('traitements-Aggrid', [App\Http\Controllers\API\TraitementController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Traitements_api_aggrid');

// la route de creation
    Route::post('traitements', [App\Http\Controllers\API\TraitementController::class, 'create'])->withoutMiddleware("throttle:api")->name('Traitements_api_create');
// la route d'edition
    Route::post('traitements/{Traitements}/update', [App\Http\Controllers\API\TraitementController::class, 'update'])->withoutMiddleware("throttle:api")->name('Traitements_api_update');
// la route de suppression
    Route::post('traitements/{Traitements}/delete', [App\Http\Controllers\API\TraitementController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Traitements_api_delete');
// la route des actions
    Route::get('traitements/action', [App\Http\Controllers\API\TraitementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Traitements_api_delete');
// la route des actions
    Route::post('traitements/action', [App\Http\Controllers\API\TraitementController::class, 'action'])->withoutMiddleware("throttle:api")->name('Traitements_api_delete');


//Route::resource('Transactionspostessyntheses',App\Http\Controllers\API\TransactionspostessyntheseController::class);
// les routes d'affichage
    Route::get('transactionspostessyntheses/{key}/{val}', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_index2');
    Route::get('transactionspostessyntheses', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_index');
    Route::post('transactionspostessyntheses-Aggrid', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_aggrid');

// la route de creation
    Route::post('transactionspostessyntheses', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_create');
// la route d'edition
    Route::post('transactionspostessyntheses/{Transactionspostessyntheses}/update', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_update');
// la route de suppression
    Route::post('transactionspostessyntheses/{Transactionspostessyntheses}/delete', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_delete');
// la route des actions
    Route::get('transactionspostessyntheses/action', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_delete');
// la route des actions
    Route::post('transactionspostessyntheses/action', [App\Http\Controllers\API\TransactionspostessyntheseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionspostessyntheses_api_delete');


// //Route::resource('Transactionspostessynthesesvacations',App\Http\Controllers\API\TransactionspostessynthesesvacationController::class);
// // les routes d'affichage
//     Route::get('transactionspostessynthesesvacations/{key}/{val}', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_index2');
//     Route::get('transactionspostessynthesesvacations', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_index');
//     Route::post('transactionspostessynthesesvacations-Aggrid', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_aggrid');

// // la route de creation
//     Route::post('transactionspostessynthesesvacations', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_create');
// // la route d'edition
//     Route::post('transactionspostessynthesesvacations/{Transactionspostessynthesesvacations}/update', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_update');
// // la route de suppression
//     Route::post('transactionspostessynthesesvacations/{Transactionspostessynthesesvacations}/delete', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_delete');
// // la route des actions
//     Route::get('transactionspostessynthesesvacations/action', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_delete');
// // la route des actions
//     Route::post('transactionspostessynthesesvacations/action', [App\Http\Controllers\API\TransactionspostessynthesesvacationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionspostessynthesesvacations_api_delete');


//Route::resource('Transactionssyntheses',App\Http\Controllers\API\TransactionssyntheseController::class);
// les routes d'affichage
    Route::get('transactionssyntheses/{key}/{val}', [App\Http\Controllers\API\TransactionssyntheseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_index2');
    Route::get('transactionssyntheses', [App\Http\Controllers\API\TransactionssyntheseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_index');
    Route::post('transactionssyntheses-Aggrid', [App\Http\Controllers\API\TransactionssyntheseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_aggrid');

// la route de creation
    Route::post('transactionssyntheses', [App\Http\Controllers\API\TransactionssyntheseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_create');
// la route d'edition
    Route::post('transactionssyntheses/{Transactionssyntheses}/update', [App\Http\Controllers\API\TransactionssyntheseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_update');
// la route de suppression
    Route::post('transactionssyntheses/{Transactionssyntheses}/delete', [App\Http\Controllers\API\TransactionssyntheseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_delete');
// la route des actions
    Route::get('transactionssyntheses/action', [App\Http\Controllers\API\TransactionssyntheseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_delete');
// la route des actions
    Route::post('transactionssyntheses/action', [App\Http\Controllers\API\TransactionssyntheseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionssyntheses_api_delete');


//Route::resource('Transactionsulterieurs',App\Http\Controllers\API\TransactionsulterieurController::class);
// les routes d'affichage
    Route::get('transactionsulterieurs/{key}/{val}', [App\Http\Controllers\API\TransactionsulterieurController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_index2');
    Route::get('transactionsulterieurs', [App\Http\Controllers\API\TransactionsulterieurController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_index');
    Route::post('transactionsulterieurs-Aggrid', [App\Http\Controllers\API\TransactionsulterieurController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_aggrid');

// la route de creation
    Route::post('transactionsulterieurs', [App\Http\Controllers\API\TransactionsulterieurController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_create');
// la route d'edition
    Route::post('transactionsulterieurs/{Transactionsulterieurs}/update', [App\Http\Controllers\API\TransactionsulterieurController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_update');
// la route de suppression
    Route::post('transactionsulterieurs/{Transactionsulterieurs}/delete', [App\Http\Controllers\API\TransactionsulterieurController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_delete');
// la route des actions
    Route::get('transactionsulterieurs/action', [App\Http\Controllers\API\TransactionsulterieurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_delete');
// la route des actions
    Route::post('transactionsulterieurs/action', [App\Http\Controllers\API\TransactionsulterieurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsulterieurs_api_delete');


//Route::resource('Transactionsuserssyntheses',App\Http\Controllers\API\TransactionsuserssyntheseController::class);
// les routes d'affichage
    Route::get('transactionsuserssyntheses/{key}/{val}', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_index2');
    Route::get('transactionsuserssyntheses', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_index');
    Route::post('transactionsuserssyntheses-Aggrid', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_aggrid');

// la route de creation
    Route::post('transactionsuserssyntheses', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_create');
// la route d'edition
    Route::post('transactionsuserssyntheses/{Transactionsuserssyntheses}/update', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_update');
// la route de suppression
    Route::post('transactionsuserssyntheses/{Transactionsuserssyntheses}/delete', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_delete');
// la route des actions
    Route::get('transactionsuserssyntheses/action', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_delete');
// la route des actions
    Route::post('transactionsuserssyntheses/action', [App\Http\Controllers\API\TransactionsuserssyntheseController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsuserssyntheses_api_delete');


// //Route::resource('Transactionsuserssynthesesvacations',App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class);
// // les routes d'affichage
//     Route::get('transactionsuserssynthesesvacations/{key}/{val}', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_index2');
//     Route::get('transactionsuserssynthesesvacations', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_index');
//     Route::post('transactionsuserssynthesesvacations-Aggrid', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_aggrid');

// // la route de creation
//     Route::post('transactionsuserssynthesesvacations', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_create');
// // la route d'edition
//     Route::post('transactionsuserssynthesesvacations/{Transactionsuserssynthesesvacations}/update', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_update');
// // la route de suppression
//     Route::post('transactionsuserssynthesesvacations/{Transactionsuserssynthesesvacations}/delete', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_delete');
// // la route des actions
//     Route::get('transactionsuserssynthesesvacations/action', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_delete');
// // la route des actions
//     Route::post('transactionsuserssynthesesvacations/action', [App\Http\Controllers\API\TransactionsuserssynthesesvacationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transactionsuserssynthesesvacations_api_delete');


//Route::resource('Transporteurs',App\Http\Controllers\API\TransporteurController::class);
// les routes d'affichage
    Route::get('transporteurs/{key}/{val}', [App\Http\Controllers\API\TransporteurController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_index2');
    Route::get('transporteurs', [App\Http\Controllers\API\TransporteurController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_index');
    Route::post('transporteurs-Aggrid', [App\Http\Controllers\API\TransporteurController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transporteurs_api_aggrid');

// la route de creation
    Route::post('transporteurs', [App\Http\Controllers\API\TransporteurController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_create');
// la route d'edition
    Route::post('transporteurs/{Transporteurs}/update', [App\Http\Controllers\API\TransporteurController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_update');
// la route de suppression
    Route::post('transporteurs/{Transporteurs}/delete', [App\Http\Controllers\API\TransporteurController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_delete');
// la route des actions
    Route::get('transporteurs/action', [App\Http\Controllers\API\TransporteurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_delete');
// la route des actions
    Route::post('transporteurs/action', [App\Http\Controllers\API\TransporteurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transporteurs_api_delete');


//Route::resource('Transporteurstrajets',App\Http\Controllers\API\TransporteurstrajetController::class);
// les routes d'affichage
    Route::get('transporteurstrajets/{key}/{val}', [App\Http\Controllers\API\TransporteurstrajetController::class, 'data'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_index2');
    Route::get('transporteurstrajets', [App\Http\Controllers\API\TransporteurstrajetController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_index');
    Route::post('transporteurstrajets-Aggrid', [App\Http\Controllers\API\TransporteurstrajetController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_aggrid');

// la route de creation
    Route::post('transporteurstrajets', [App\Http\Controllers\API\TransporteurstrajetController::class, 'create'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_create');
// la route d'edition
    Route::post('transporteurstrajets/{Transporteurstrajets}/update', [App\Http\Controllers\API\TransporteurstrajetController::class, 'update'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_update');
// la route de suppression
    Route::post('transporteurstrajets/{Transporteurstrajets}/delete', [App\Http\Controllers\API\TransporteurstrajetController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_delete');
// la route des actions
    Route::get('transporteurstrajets/action', [App\Http\Controllers\API\TransporteurstrajetController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_delete');
// la route des actions
    Route::post('transporteurstrajets/action', [App\Http\Controllers\API\TransporteurstrajetController::class, 'action'])->withoutMiddleware("throttle:api")->name('Transporteurstrajets_api_delete');


//Route::resource('Travailleurs',App\Http\Controllers\API\TravailleurController::class);
// les routes d'affichage
    Route::get('travailleurs/{key}/{val}', [App\Http\Controllers\API\TravailleurController::class, 'data'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_index2');
    Route::get('travailleurs', [App\Http\Controllers\API\TravailleurController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_index');
    Route::post('travailleurs-Aggrid', [App\Http\Controllers\API\TravailleurController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Travailleurs_api_aggrid');

// la route de creation
    Route::post('travailleurs', [App\Http\Controllers\API\TravailleurController::class, 'create'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_create');
// la route d'edition
    Route::post('travailleurs/{Travailleurs}/update', [App\Http\Controllers\API\TravailleurController::class, 'update'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_update');
// la route de suppression
    Route::post('travailleurs/{Travailleurs}/delete', [App\Http\Controllers\API\TravailleurController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_delete');
// la route des actions
    Route::get('travailleurs/action', [App\Http\Controllers\API\TravailleurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_delete');
// la route des actions
    Route::post('travailleurs/action', [App\Http\Controllers\API\TravailleurController::class, 'action'])->withoutMiddleware("throttle:api")->name('Travailleurs_api_delete');


//Route::resource('Typeinterventions',App\Http\Controllers\API\TypeinterventionController::class);
// les routes d'affichage
    Route::get('typeinterventions/{key}/{val}', [App\Http\Controllers\API\TypeinterventionController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_index2');
    Route::get('typeinterventions', [App\Http\Controllers\API\TypeinterventionController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_index');
    Route::post('typeinterventions-Aggrid', [App\Http\Controllers\API\TypeinterventionController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typeinterventions_api_aggrid');

// la route de creation
    Route::post('typeinterventions', [App\Http\Controllers\API\TypeinterventionController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_create');
// la route d'edition
    Route::post('typeinterventions/{Typeinterventions}/update', [App\Http\Controllers\API\TypeinterventionController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_update');
// la route de suppression
    Route::post('typeinterventions/{Typeinterventions}/delete', [App\Http\Controllers\API\TypeinterventionController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_delete');
// la route des actions
    Route::get('typeinterventions/action', [App\Http\Controllers\API\TypeinterventionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_delete');
// la route des actions
    Route::post('typeinterventions/action', [App\Http\Controllers\API\TypeinterventionController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typeinterventions_api_delete');


//Route::resource('Types',App\Http\Controllers\API\TypeController::class);
// les routes d'affichage
    Route::get('types/{key}/{val}', [App\Http\Controllers\API\TypeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Types_api_index2');
    Route::get('types', [App\Http\Controllers\API\TypeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Types_api_index');
    Route::post('types-Aggrid', [App\Http\Controllers\API\TypeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Types_api_aggrid');

// la route de creation
    Route::post('types', [App\Http\Controllers\API\TypeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Types_api_create');
// la route d'edition
    Route::post('types/{Types}/update', [App\Http\Controllers\API\TypeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Types_api_update');
// la route de suppression
    Route::post('types/{Types}/delete', [App\Http\Controllers\API\TypeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Types_api_delete');
// la route des actions
    Route::get('types/action', [App\Http\Controllers\API\TypeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Types_api_delete');
// la route des actions
    Route::post('types/action', [App\Http\Controllers\API\TypeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Types_api_delete');


//Route::resource('Typesabscences',App\Http\Controllers\API\TypesabscenceController::class);
// les routes d'affichage
    Route::get('typesabscences/{key}/{val}', [App\Http\Controllers\API\TypesabscenceController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_index2');
    Route::get('typesabscences', [App\Http\Controllers\API\TypesabscenceController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_index');
    Route::post('typesabscences-Aggrid', [App\Http\Controllers\API\TypesabscenceController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typesabscences_api_aggrid');

// la route de creation
    Route::post('typesabscences', [App\Http\Controllers\API\TypesabscenceController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_create');
// la route d'edition
    Route::post('typesabscences/{Typesabscences}/update', [App\Http\Controllers\API\TypesabscenceController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_update');
// la route de suppression
    Route::post('typesabscences/{Typesabscences}/delete', [App\Http\Controllers\API\TypesabscenceController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_delete');
// la route des actions
    Route::get('typesabscences/action', [App\Http\Controllers\API\TypesabscenceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_delete');
// la route des actions
    Route::post('typesabscences/action', [App\Http\Controllers\API\TypesabscenceController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesabscences_api_delete');


//Route::resource('Typesagentshoraires',App\Http\Controllers\API\TypesagentshoraireController::class);
// les routes d'affichage
    Route::get('typesagentshoraires/{key}/{val}', [App\Http\Controllers\API\TypesagentshoraireController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_index2');
    Route::get('typesagentshoraires', [App\Http\Controllers\API\TypesagentshoraireController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_index');
    Route::post('typesagentshoraires-Aggrid', [App\Http\Controllers\API\TypesagentshoraireController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_aggrid');

// la route de creation
    Route::post('typesagentshoraires', [App\Http\Controllers\API\TypesagentshoraireController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_create');
// la route d'edition
    Route::post('typesagentshoraires/{Typesagentshoraires}/update', [App\Http\Controllers\API\TypesagentshoraireController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_update');
// la route de suppression
    Route::post('typesagentshoraires/{Typesagentshoraires}/delete', [App\Http\Controllers\API\TypesagentshoraireController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_delete');
// la route des actions
    Route::get('typesagentshoraires/action', [App\Http\Controllers\API\TypesagentshoraireController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_delete');
// la route des actions
    Route::post('typesagentshoraires/action', [App\Http\Controllers\API\TypesagentshoraireController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesagentshoraires_api_delete');


//Route::resource('Typeseffectifs',App\Http\Controllers\API\TypeseffectifController::class);
// les routes d'affichage
    Route::get('typeseffectifs/{key}/{val}', [App\Http\Controllers\API\TypeseffectifController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_index2');
    Route::get('typeseffectifs', [App\Http\Controllers\API\TypeseffectifController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_index');
    Route::post('typeseffectifs-Aggrid', [App\Http\Controllers\API\TypeseffectifController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_aggrid');

// la route de creation
    Route::post('typeseffectifs', [App\Http\Controllers\API\TypeseffectifController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_create');
// la route d'edition
    Route::post('typeseffectifs/{Typeseffectifs}/update', [App\Http\Controllers\API\TypeseffectifController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_update');
// la route de suppression
    Route::post('typeseffectifs/{Typeseffectifs}/delete', [App\Http\Controllers\API\TypeseffectifController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_delete');
// la route des actions
    Route::get('typeseffectifs/action', [App\Http\Controllers\API\TypeseffectifController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_delete');
// la route des actions
    Route::post('typeseffectifs/action', [App\Http\Controllers\API\TypeseffectifController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typeseffectifs_api_delete');


//Route::resource('Typespointages',App\Http\Controllers\API\TypespointageController::class);
// les routes d'affichage
    Route::get('typespointages/{key}/{val}', [App\Http\Controllers\API\TypespointageController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typespointages_api_index2');
    Route::get('typespointages', [App\Http\Controllers\API\TypespointageController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typespointages_api_index');
    Route::post('typespointages-Aggrid', [App\Http\Controllers\API\TypespointageController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typespointages_api_aggrid');

// la route de creation
    Route::post('typespointages', [App\Http\Controllers\API\TypespointageController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typespointages_api_create');
// la route d'edition
    Route::post('typespointages/{Typespointages}/update', [App\Http\Controllers\API\TypespointageController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typespointages_api_update');
// la route de suppression
    Route::post('typespointages/{Typespointages}/delete', [App\Http\Controllers\API\TypespointageController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typespointages_api_delete');
// la route des actions
    Route::get('typespointages/action', [App\Http\Controllers\API\TypespointageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typespointages_api_delete');
// la route des actions
    Route::post('typespointages/action', [App\Http\Controllers\API\TypespointageController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typespointages_api_delete');


//Route::resource('Typesheures',App\Http\Controllers\API\TypesheureController::class);
// les routes d'affichage
    Route::get('typesheures/{key}/{val}', [App\Http\Controllers\API\TypesheureController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typesheures_api_index2');
    Route::get('typesheures', [App\Http\Controllers\API\TypesheureController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typesheures_api_index');
    Route::post('typesheures-Aggrid', [App\Http\Controllers\API\TypesheureController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typesheures_api_aggrid');

// la route de creation
    Route::post('typesheures', [App\Http\Controllers\API\TypesheureController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typesheures_api_create');
// la route d'edition
    Route::post('typesheures/{Typesheures}/update', [App\Http\Controllers\API\TypesheureController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typesheures_api_update');
// la route de suppression
    Route::post('typesheures/{Typesheures}/delete', [App\Http\Controllers\API\TypesheureController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typesheures_api_delete');
// la route des actions
    Route::get('typesheures/action', [App\Http\Controllers\API\TypesheureController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesheures_api_delete');
// la route des actions
    Route::post('typesheures/action', [App\Http\Controllers\API\TypesheureController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesheures_api_delete');


//Route::resource('Typesmoyenstransports',App\Http\Controllers\API\TypesmoyenstransportController::class);
// les routes d'affichage
    Route::get('typesmoyenstransports/{key}/{val}', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_index2');
    Route::get('typesmoyenstransports', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_index');
    Route::post('typesmoyenstransports-Aggrid', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_aggrid');

// la route de creation
    Route::post('typesmoyenstransports', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_create');
// la route d'edition
    Route::post('typesmoyenstransports/{Typesmoyenstransports}/update', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_update');
// la route de suppression
    Route::post('typesmoyenstransports/{Typesmoyenstransports}/delete', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_delete');
// la route des actions
    Route::get('typesmoyenstransports/action', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_delete');
// la route des actions
    Route::post('typesmoyenstransports/action', [App\Http\Controllers\API\TypesmoyenstransportController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesmoyenstransports_api_delete');


//Route::resource('Typespostes',App\Http\Controllers\API\TypesposteController::class);
// les routes d'affichage
    Route::get('typespostes/{key}/{val}', [App\Http\Controllers\API\TypesposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typespostes_api_index2');
    Route::get('typespostes', [App\Http\Controllers\API\TypesposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typespostes_api_index');
    Route::post('typespostes-Aggrid', [App\Http\Controllers\API\TypesposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typespostes_api_aggrid');

// la route de creation
    Route::post('typespostes', [App\Http\Controllers\API\TypesposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typespostes_api_create');
// la route d'edition
    Route::post('typespostes/{Typespostes}/update', [App\Http\Controllers\API\TypesposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typespostes_api_update');
// la route de suppression
    Route::post('typespostes/{Typespostes}/delete', [App\Http\Controllers\API\TypesposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typespostes_api_delete');
// la route des actions
    Route::get('typespostes/action', [App\Http\Controllers\API\TypesposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typespostes_api_delete');
// la route des actions
    Route::post('typespostes/action', [App\Http\Controllers\API\TypesposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typespostes_api_delete');


//Route::resource('Typessites',App\Http\Controllers\API\TypessiteController::class);
// les routes d'affichage
    Route::get('typessites/{key}/{val}', [App\Http\Controllers\API\TypessiteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typessites_api_index2');
    Route::get('typessites', [App\Http\Controllers\API\TypessiteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typessites_api_index');
    Route::post('typessites-Aggrid', [App\Http\Controllers\API\TypessiteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typessites_api_aggrid');

// la route de creation
    Route::post('typessites', [App\Http\Controllers\API\TypessiteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typessites_api_create');
// la route d'edition
    Route::post('typessites/{Typessites}/update', [App\Http\Controllers\API\TypessiteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typessites_api_update');
// la route de suppression
    Route::post('typessites/{Typessites}/delete', [App\Http\Controllers\API\TypessiteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typessites_api_delete');
// la route des actions
    Route::get('typessites/action', [App\Http\Controllers\API\TypessiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typessites_api_delete');
// la route des actions
    Route::post('typessites/action', [App\Http\Controllers\API\TypessiteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typessites_api_delete');


//Route::resource('Typestaches',App\Http\Controllers\API\TypestacheController::class);
// les routes d'affichage
    Route::get('typestaches/{key}/{val}', [App\Http\Controllers\API\TypestacheController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typestaches_api_index2');
    Route::get('typestaches', [App\Http\Controllers\API\TypestacheController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typestaches_api_index');
    Route::post('typestaches-Aggrid', [App\Http\Controllers\API\TypestacheController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typestaches_api_aggrid');

// la route de creation
    Route::post('typestaches', [App\Http\Controllers\API\TypestacheController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typestaches_api_create');
// la route d'edition
    Route::post('typestaches/{Typestaches}/update', [App\Http\Controllers\API\TypestacheController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typestaches_api_update');
// la route de suppression
    Route::post('typestaches/{Typestaches}/delete', [App\Http\Controllers\API\TypestacheController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typestaches_api_delete');
// la route des actions
    Route::get('typestaches/action', [App\Http\Controllers\API\TypestacheController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typestaches_api_delete');
// la route des actions
    Route::post('typestaches/action', [App\Http\Controllers\API\TypestacheController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typestaches_api_delete');


//Route::resource('Typesventilations',App\Http\Controllers\API\TypesventilationController::class);
// les routes d'affichage
    Route::get('typesventilations/{key}/{val}', [App\Http\Controllers\API\TypesventilationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_index2');
    Route::get('typesventilations', [App\Http\Controllers\API\TypesventilationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_index');
    Route::post('typesventilations-Aggrid', [App\Http\Controllers\API\TypesventilationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Typesventilations_api_aggrid');

// la route de creation
    Route::post('typesventilations', [App\Http\Controllers\API\TypesventilationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_create');
// la route d'edition
    Route::post('typesventilations/{Typesventilations}/update', [App\Http\Controllers\API\TypesventilationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_update');
// la route de suppression
    Route::post('typesventilations/{Typesventilations}/delete', [App\Http\Controllers\API\TypesventilationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_delete');
// la route des actions
    Route::get('typesventilations/action', [App\Http\Controllers\API\TypesventilationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_delete');
// la route des actions
    Route::post('typesventilations/action', [App\Http\Controllers\API\TypesventilationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Typesventilations_api_delete');


//Route::resource('Userbadges',App\Http\Controllers\API\UserbadgeController::class);
// les routes d'affichage
    Route::get('userbadges/{key}/{val}', [App\Http\Controllers\API\UserbadgeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Userbadges_api_index2');
    Route::get('userbadges', [App\Http\Controllers\API\UserbadgeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Userbadges_api_index');
    Route::post('userbadges-Aggrid', [App\Http\Controllers\API\UserbadgeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Userbadges_api_aggrid');

// la route de creation
    Route::post('userbadges', [App\Http\Controllers\API\UserbadgeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Userbadges_api_create');
// la route d'edition
    Route::post('userbadges/{Userbadges}/update', [App\Http\Controllers\API\UserbadgeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Userbadges_api_update');
// la route de suppression
    Route::post('userbadges/{Userbadges}/delete', [App\Http\Controllers\API\UserbadgeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Userbadges_api_delete');
// la route des actions
    Route::get('userbadges/action', [App\Http\Controllers\API\UserbadgeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Userbadges_api_delete');
// la route des actions
    Route::post('userbadges/action', [App\Http\Controllers\API\UserbadgeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Userbadges_api_delete');


//Route::resource('Users',App\Http\Controllers\API\UserController::class);
// les routes d'affichage
    Route::get('users/{key}/{val}', [App\Http\Controllers\API\UserController::class, 'data'])->withoutMiddleware("throttle:api")->name('Users_api_index2');
    Route::get('users', [App\Http\Controllers\API\UserController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Users_api_index');
    Route::post('users-Aggrid', [App\Http\Controllers\API\UserController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Users_api_aggrid');

// la route de creation
    Route::post('users', [App\Http\Controllers\API\UserController::class, 'create'])->withoutMiddleware("throttle:api")->name('Users_api_create');
// la route d'edition
    Route::post('users/{Users}/update', [App\Http\Controllers\API\UserController::class, 'update'])->withoutMiddleware("throttle:api")->name('Users_api_update');
// la route de suppression
    Route::post('users/{Users}/delete', [App\Http\Controllers\API\UserController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Users_api_delete');
// la route des actions
    Route::get('users/action', [App\Http\Controllers\API\UserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Users_api_delete');
// la route des actions
    Route::post('users/action', [App\Http\Controllers\API\UserController::class, 'action'])->withoutMiddleware("throttle:api")->name('Users_api_delete');


//Route::resource('Usersgraphiques',App\Http\Controllers\API\UsersgraphiqueController::class);
// les routes d'affichage
    Route::get('usersgraphiques/{key}/{val}', [App\Http\Controllers\API\UsersgraphiqueController::class, 'data'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_index2');
    Route::get('usersgraphiques', [App\Http\Controllers\API\UsersgraphiqueController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_index');
    Route::post('usersgraphiques-Aggrid', [App\Http\Controllers\API\UsersgraphiqueController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_aggrid');

// la route de creation
    Route::post('usersgraphiques', [App\Http\Controllers\API\UsersgraphiqueController::class, 'create'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_create');
// la route d'edition
    Route::post('usersgraphiques/{Usersgraphiques}/update', [App\Http\Controllers\API\UsersgraphiqueController::class, 'update'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_update');
// la route de suppression
    Route::post('usersgraphiques/{Usersgraphiques}/delete', [App\Http\Controllers\API\UsersgraphiqueController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_delete');
// la route des actions
    Route::get('usersgraphiques/action', [App\Http\Controllers\API\UsersgraphiqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_delete');
// la route des actions
    Route::post('usersgraphiques/action', [App\Http\Controllers\API\UsersgraphiqueController::class, 'action'])->withoutMiddleware("throttle:api")->name('Usersgraphiques_api_delete');


//Route::resource('Userstypespostes',App\Http\Controllers\API\UserstypesposteController::class);
// les routes d'affichage
    Route::get('userstypespostes/{key}/{val}', [App\Http\Controllers\API\UserstypesposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_index2');
    Route::get('userstypespostes', [App\Http\Controllers\API\UserstypesposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_index');
    Route::post('userstypespostes-Aggrid', [App\Http\Controllers\API\UserstypesposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Userstypespostes_api_aggrid');

// la route de creation
    Route::post('userstypespostes', [App\Http\Controllers\API\UserstypesposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_create');
// la route d'edition
    Route::post('userstypespostes/{Userstypespostes}/update', [App\Http\Controllers\API\UserstypesposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_update');
// la route de suppression
    Route::post('userstypespostes/{Userstypespostes}/delete', [App\Http\Controllers\API\UserstypesposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_delete');
// la route des actions
    Route::get('userstypespostes/action', [App\Http\Controllers\API\UserstypesposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_delete');
// la route des actions
    Route::post('userstypespostes/action', [App\Http\Controllers\API\UserstypesposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Userstypespostes_api_delete');


//Route::resource('Userszones',App\Http\Controllers\API\UserszoneController::class);
// les routes d'affichage
    Route::get('userszones/{key}/{val}', [App\Http\Controllers\API\UserszoneController::class, 'data'])->withoutMiddleware("throttle:api")->name('Userszones_api_index2');
    Route::get('userszones', [App\Http\Controllers\API\UserszoneController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Userszones_api_index');
    Route::post('userszones-Aggrid', [App\Http\Controllers\API\UserszoneController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Userszones_api_aggrid');

// la route de creation
    Route::post('userszones', [App\Http\Controllers\API\UserszoneController::class, 'create'])->withoutMiddleware("throttle:api")->name('Userszones_api_create');
// la route d'edition
    Route::post('userszones/{Userszones}/update', [App\Http\Controllers\API\UserszoneController::class, 'update'])->withoutMiddleware("throttle:api")->name('Userszones_api_update');
// la route de suppression
    Route::post('userszones/{Userszones}/delete', [App\Http\Controllers\API\UserszoneController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Userszones_api_delete');
// la route des actions
    Route::get('userszones/action', [App\Http\Controllers\API\UserszoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Userszones_api_delete');
// la route des actions
    Route::post('userszones/action', [App\Http\Controllers\API\UserszoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Userszones_api_delete');


//Route::resource('Vacationspostes',App\Http\Controllers\API\VacationsposteController::class);
// les routes d'affichage
    Route::get('vacationspostes/{key}/{val}', [App\Http\Controllers\API\VacationsposteController::class, 'data'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_index2');
    Route::get('vacationspostes', [App\Http\Controllers\API\VacationsposteController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_index');
    Route::post('vacationspostes-Aggrid', [App\Http\Controllers\API\VacationsposteController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Vacationspostes_api_aggrid');

// la route de creation
    Route::post('vacationspostes', [App\Http\Controllers\API\VacationsposteController::class, 'create'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_create');
// la route d'edition
    Route::post('vacationspostes/{Vacationspostes}/update', [App\Http\Controllers\API\VacationsposteController::class, 'update'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_update');
// la route de suppression
    Route::post('vacationspostes/{Vacationspostes}/delete', [App\Http\Controllers\API\VacationsposteController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_delete');
// la route des actions
    Route::get('vacationspostes/action', [App\Http\Controllers\API\VacationsposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_delete');
// la route des actions
    Route::post('vacationspostes/action', [App\Http\Controllers\API\VacationsposteController::class, 'action'])->withoutMiddleware("throttle:api")->name('Vacationspostes_api_delete');


//Route::resource('Validations',App\Http\Controllers\API\ValidationController::class);
// les routes d'affichage
    Route::get('validations/{key}/{val}', [App\Http\Controllers\API\ValidationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Validations_api_index2');
    Route::get('validations', [App\Http\Controllers\API\ValidationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Validations_api_index');
    Route::post('validations-Aggrid', [App\Http\Controllers\API\ValidationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Validations_api_aggrid');

// la route de creation
    Route::post('validations', [App\Http\Controllers\API\ValidationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Validations_api_create');
// la route d'edition
    Route::post('validations/{Validations}/update', [App\Http\Controllers\API\ValidationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Validations_api_update');
// la route de suppression
    Route::post('validations/{Validations}/delete', [App\Http\Controllers\API\ValidationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Validations_api_delete');
// la route des actions
    Route::get('validations/action', [App\Http\Controllers\API\ValidationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Validations_api_delete');
// la route des actions
    Route::post('validations/action', [App\Http\Controllers\API\ValidationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Validations_api_delete');


//Route::resource('Variables',App\Http\Controllers\API\VariableController::class);
// les routes d'affichage
    Route::get('variables/{key}/{val}', [App\Http\Controllers\API\VariableController::class, 'data'])->withoutMiddleware("throttle:api")->name('Variables_api_index2');
    Route::get('variables', [App\Http\Controllers\API\VariableController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Variables_api_index');
    Route::post('variables-Aggrid', [App\Http\Controllers\API\VariableController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Variables_api_aggrid');

// la route de creation
    Route::post('variables', [App\Http\Controllers\API\VariableController::class, 'create'])->withoutMiddleware("throttle:api")->name('Variables_api_create');
// la route d'edition
    Route::post('variables/{Variables}/update', [App\Http\Controllers\API\VariableController::class, 'update'])->withoutMiddleware("throttle:api")->name('Variables_api_update');
// la route de suppression
    Route::post('variables/{Variables}/delete', [App\Http\Controllers\API\VariableController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Variables_api_delete');
// la route des actions
    Route::get('variables/action', [App\Http\Controllers\API\VariableController::class, 'action'])->withoutMiddleware("throttle:api")->name('Variables_api_delete');
// la route des actions
    Route::post('variables/action', [App\Http\Controllers\API\VariableController::class, 'action'])->withoutMiddleware("throttle:api")->name('Variables_api_delete');


//Route::resource('Vehicules',App\Http\Controllers\API\VehiculeController::class);
// les routes d'affichage
    Route::get('vehicules/{key}/{val}', [App\Http\Controllers\API\VehiculeController::class, 'data'])->withoutMiddleware("throttle:api")->name('Vehicules_api_index2');
    Route::get('vehicules', [App\Http\Controllers\API\VehiculeController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Vehicules_api_index');
    Route::post('vehicules-Aggrid', [App\Http\Controllers\API\VehiculeController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Vehicules_api_aggrid');

// la route de creation
    Route::post('vehicules', [App\Http\Controllers\API\VehiculeController::class, 'create'])->withoutMiddleware("throttle:api")->name('Vehicules_api_create');
// la route d'edition
    Route::post('vehicules/{Vehicules}/update', [App\Http\Controllers\API\VehiculeController::class, 'update'])->withoutMiddleware("throttle:api")->name('Vehicules_api_update');
// la route de suppression
    Route::post('vehicules/{Vehicules}/delete', [App\Http\Controllers\API\VehiculeController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Vehicules_api_delete');
// la route des actions
    Route::get('vehicules/action', [App\Http\Controllers\API\VehiculeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Vehicules_api_delete');
// la route des actions
    Route::post('vehicules/action', [App\Http\Controllers\API\VehiculeController::class, 'action'])->withoutMiddleware("throttle:api")->name('Vehicules_api_delete');


//Route::resource('Ventilations',App\Http\Controllers\API\VentilationController::class);
// les routes d'affichage
    Route::get('ventilations/{key}/{val}', [App\Http\Controllers\API\VentilationController::class, 'data'])->withoutMiddleware("throttle:api")->name('Ventilations_api_index2');
    Route::get('ventilations', [App\Http\Controllers\API\VentilationController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Ventilations_api_index');
    Route::post('ventilations-Aggrid', [App\Http\Controllers\API\VentilationController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Ventilations_api_aggrid');

// la route de creation
    Route::post('ventilations', [App\Http\Controllers\API\VentilationController::class, 'create'])->withoutMiddleware("throttle:api")->name('Ventilations_api_create');
// la route d'edition
    Route::post('ventilations/{Ventilations}/update', [App\Http\Controllers\API\VentilationController::class, 'update'])->withoutMiddleware("throttle:api")->name('Ventilations_api_update');
// la route de suppression
    Route::post('ventilations/{Ventilations}/delete', [App\Http\Controllers\API\VentilationController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Ventilations_api_delete');
// la route des actions
    Route::get('ventilations/action', [App\Http\Controllers\API\VentilationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Ventilations_api_delete');
// la route des actions
    Route::post('ventilations/action', [App\Http\Controllers\API\VentilationController::class, 'action'])->withoutMiddleware("throttle:api")->name('Ventilations_api_delete');


//Route::resource('Villes',App\Http\Controllers\API\VilleController::class);
// les routes d'affichage
    Route::get('villes/{key}/{val}', [App\Http\Controllers\API\VilleController::class, 'data'])->withoutMiddleware("throttle:api")->name('Villes_api_index2');
    Route::get('villes', [App\Http\Controllers\API\VilleController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Villes_api_index');
    Route::post('villes-Aggrid', [App\Http\Controllers\API\VilleController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Villes_api_aggrid');

// la route de creation
    Route::post('villes', [App\Http\Controllers\API\VilleController::class, 'create'])->withoutMiddleware("throttle:api")->name('Villes_api_create');
// la route d'edition
    Route::post('villes/{Villes}/update', [App\Http\Controllers\API\VilleController::class, 'update'])->withoutMiddleware("throttle:api")->name('Villes_api_update');
// la route de suppression
    Route::post('villes/{Villes}/delete', [App\Http\Controllers\API\VilleController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Villes_api_delete');
// la route des actions
    Route::get('villes/action', [App\Http\Controllers\API\VilleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Villes_api_delete');
// la route des actions
    Route::post('villes/action', [App\Http\Controllers\API\VilleController::class, 'action'])->withoutMiddleware("throttle:api")->name('Villes_api_delete');


//Route::resource('Villeszones',App\Http\Controllers\API\VilleszoneController::class);
// les routes d'affichage
    Route::get('villeszones/{key}/{val}', [App\Http\Controllers\API\VilleszoneController::class, 'data'])->withoutMiddleware("throttle:api")->name('Villeszones_api_index2');
    Route::get('villeszones', [App\Http\Controllers\API\VilleszoneController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Villeszones_api_index');
    Route::post('villeszones-Aggrid', [App\Http\Controllers\API\VilleszoneController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Villeszones_api_aggrid');

// la route de creation
    Route::post('villeszones', [App\Http\Controllers\API\VilleszoneController::class, 'create'])->withoutMiddleware("throttle:api")->name('Villeszones_api_create');
// la route d'edition
    Route::post('villeszones/{Villeszones}/update', [App\Http\Controllers\API\VilleszoneController::class, 'update'])->withoutMiddleware("throttle:api")->name('Villeszones_api_update');
// la route de suppression
    Route::post('villeszones/{Villeszones}/delete', [App\Http\Controllers\API\VilleszoneController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Villeszones_api_delete');
// la route des actions
    Route::get('villeszones/action', [App\Http\Controllers\API\VilleszoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Villeszones_api_delete');
// la route des actions
    Route::post('villeszones/action', [App\Http\Controllers\API\VilleszoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Villeszones_api_delete');


//Route::resource('Voitures',App\Http\Controllers\API\VoitureController::class);
// les routes d'affichage
    Route::get('voitures/{key}/{val}', [App\Http\Controllers\API\VoitureController::class, 'data'])->withoutMiddleware("throttle:api")->name('Voitures_api_index2');
    Route::get('voitures', [App\Http\Controllers\API\VoitureController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Voitures_api_index');
    Route::post('voitures-Aggrid', [App\Http\Controllers\API\VoitureController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Voitures_api_aggrid');

// la route de creation
    Route::post('voitures', [App\Http\Controllers\API\VoitureController::class, 'create'])->withoutMiddleware("throttle:api")->name('Voitures_api_create');
// la route d'edition
    Route::post('voitures/{Voitures}/update', [App\Http\Controllers\API\VoitureController::class, 'update'])->withoutMiddleware("throttle:api")->name('Voitures_api_update');
// la route de suppression
    Route::post('voitures/{Voitures}/delete', [App\Http\Controllers\API\VoitureController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Voitures_api_delete');
// la route des actions
    Route::get('voitures/action', [App\Http\Controllers\API\VoitureController::class, 'action'])->withoutMiddleware("throttle:api")->name('Voitures_api_delete');
// la route des actions
    Route::post('voitures/action', [App\Http\Controllers\API\VoitureController::class, 'action'])->withoutMiddleware("throttle:api")->name('Voitures_api_delete');


//Route::resource('Websockets_statistics_entries',App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class);
// les routes d'affichage
    Route::get('websockets_statistics_entries/{key}/{val}', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'data'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_index2');
    Route::get('websockets_statistics_entries', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_index');
    Route::post('websockets_statistics_entries-Aggrid', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_aggrid');

// la route de creation
    Route::post('websockets_statistics_entries', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'create'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_create');
// la route d'edition
    Route::post('websockets_statistics_entries/{Websockets_statistics_entries}/update', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'update'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_update');
// la route de suppression
    Route::post('websockets_statistics_entries/{Websockets_statistics_entries}/delete', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_delete');
// la route des actions
    Route::get('websockets_statistics_entries/action', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'action'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_delete');
// la route des actions
    Route::post('websockets_statistics_entries/action', [App\Http\Controllers\API\WebsocketsStatisticsEntrieController::class, 'action'])->withoutMiddleware("throttle:api")->name('Websockets_statistics_entries_api_delete');


//Route::resource('Works',App\Http\Controllers\API\WorkController::class);
// les routes d'affichage
    Route::get('works/{key}/{val}', [App\Http\Controllers\API\WorkController::class, 'data'])->withoutMiddleware("throttle:api")->name('Works_api_index2');
    Route::get('works', [App\Http\Controllers\API\WorkController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Works_api_index');
    Route::post('works-Aggrid', [App\Http\Controllers\API\WorkController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Works_api_aggrid');

// la route de creation
    Route::post('works', [App\Http\Controllers\API\WorkController::class, 'create'])->withoutMiddleware("throttle:api")->name('Works_api_create');
// la route d'edition
    Route::post('works/{Works}/update', [App\Http\Controllers\API\WorkController::class, 'update'])->withoutMiddleware("throttle:api")->name('Works_api_update');
// la route de suppression
    Route::post('works/{Works}/delete', [App\Http\Controllers\API\WorkController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Works_api_delete');
// la route des actions
    Route::get('works/action', [App\Http\Controllers\API\WorkController::class, 'action'])->withoutMiddleware("throttle:api")->name('Works_api_delete');
// la route des actions
    Route::post('works/action', [App\Http\Controllers\API\WorkController::class, 'action'])->withoutMiddleware("throttle:api")->name('Works_api_delete');


//Route::resource('Zones',App\Http\Controllers\API\ZoneController::class);
// les routes d'affichage
    Route::get('zones/{key}/{val}', [App\Http\Controllers\API\ZoneController::class, 'data'])->withoutMiddleware("throttle:api")->name('Zones_api_index2');
    Route::get('zones', [App\Http\Controllers\API\ZoneController::class, 'data1'])->withoutMiddleware("throttle:api")->name('Zones_api_index');
    Route::post('zones-Aggrid', [App\Http\Controllers\API\ZoneController::class, 'agGridData'])->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->withoutMiddleware("throttle:api")->name('Zones_api_aggrid');

// la route de creation
    Route::post('zones', [App\Http\Controllers\API\ZoneController::class, 'create'])->withoutMiddleware("throttle:api")->name('Zones_api_create');
// la route d'edition
    Route::post('zones/{Zones}/update', [App\Http\Controllers\API\ZoneController::class, 'update'])->withoutMiddleware("throttle:api")->name('Zones_api_update');
// la route de suppression
    Route::post('zones/{Zones}/delete', [App\Http\Controllers\API\ZoneController::class, 'delete'])->withoutMiddleware("throttle:api")->name('Zones_api_delete');
// la route des actions
    Route::get('zones/action', [App\Http\Controllers\API\ZoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Zones_api_delete');
// la route des actions
    Route::post('zones/action', [App\Http\Controllers\API\ZoneController::class, 'action'])->withoutMiddleware("throttle:api")->name('Zones_api_delete');


});

