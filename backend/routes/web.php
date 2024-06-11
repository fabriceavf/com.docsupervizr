<?php

use App\Helpers\Helpers;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();


// Auth::routes();
Auth::routes();
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});
Route::get('/', function () {

    return redirect()->route('HOMES_web_index', ['domain' => Helpers::getAppName()]);
})->name('home');

Helpers::getAppName();
Route::get('/MAPS', [App\Http\Controllers\StaterkitController::class, 'map'])->name('MAPS');
Route::get('/testEvent', [App\Http\Controllers\StaterkitController::class, 'testEvent'])->name('testEvent');
Route::get('/DesignListing', [App\Http\Controllers\StaterkitController::class, 'designlisting'])->name('DesignListing');
Route::get('/DesignProgrammation', [App\Http\Controllers\StaterkitController::class, 'designProgrammation'])->name('DesignProgrammation');
Route::get('/rasberry', [App\Http\Controllers\StaterkitController::class, 'rasberry'])->name('rasberry');
Route::get('/useCase', [App\Http\Controllers\UseCases::class, 'create'])->name('changeclient');
Route::post('/useCase', [App\Http\Controllers\UseCases::class, 'create'])->name('changeclient');


Route::domain('{domain}.supervizr.net')->group(function () {
    Route::get('/autoConnect', [App\Http\Controllers\StaterkitController::class, 'autoConnect'])->name('autoConnect');
});


// les routes de base
Route::group(['prefix' => '', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/ONE', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_ONE_web_index');
    Route::get('/SU', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_SU_web_index');
    Route::get('/VALIDER', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_VALIDER_web_index');
    Route::get('/ENROLEMENTS', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_ENROLEMENTS_web_index');
    Route::get('/PRESENCES', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index'])->name('Programmes_PRESENCES_web_index');
    Route::get('/ABSCENCES', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index'])->name('Programmes_ABSCENCES_web_index');
    Route::get('/DEPASSEMENTS', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index'])->name('Programmes_DEPASSEMENTS_web_index');
    Route::get('/INCOMPLETS', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index'])->name('Programmes_INCOMPLETS_web_index');
    Route::get('/EXCEPTIONS', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index'])->name('Programmes_EXCEPTIONS_web_index');
    Route::get('/LISTING', [App\Http\Controllers\WEB\ProgrammationsControllerWeb::class, 'index'])->name('Programmations_LISTINGS_web_index');
    Route::get('/LISTING-POSTE', [App\Http\Controllers\WEB\ProgrammationsControllerWeb::class, 'index'])->name('Programmations_LISTINGS_Postes_web_index');
    Route::get('/RAPPORTS', [App\Http\Controllers\WEB\ModelslistingsControllerWeb::class, 'index'])->name('Modelslistings_RAPPORTS_web_index');
    Route::get('/LISTING-MANUEL', [App\Http\Controllers\WEB\ListingsjoursControllerWeb::class, 'index'])->name('Listingsjours_LISTING-MANUEL_web_index');
    Route::get('/LISTING-AUTOMATIQUE', [App\Http\Controllers\WEB\ListingsjoursControllerWeb::class, 'index'])->name('Listingsjours_LISTING-AUTOMATIQUE_web_index');
    Route::get('/Postes-interne', [App\Http\Controllers\WEB\PostesControllerWeb::class, 'index'])->name('Postes_non_importer_web_index');
    Route::get('/Postes-operation', [App\Http\Controllers\WEB\PostesControllerWeb::class, 'index'])->name('Postes_operationnel_web_index');
    Route::get('/Postes-baladeur', [App\Http\Controllers\WEB\PostesControllerWeb::class, 'index'])->name('Postes_Baladeur_web_index');
    Route::get('/Postes-surete_aeriene', [App\Http\Controllers\WEB\PostesControllerWeb::class, 'index'])->name('Postes_surete_aeriene_web_index');
    Route::get('Programmations-valider-1', [App\Http\Controllers\WEB\ProgrammationsControllerWeb::class, 'index'])->name('Programmations_LISTINGS_Valider1_web_index');
    Route::get('Programmations-valider-2', [App\Http\Controllers\WEB\ProgrammationsControllerWeb::class, 'index'])->name('Programmations_LISTINGS_Valider2_web_index');
    Route::get('Activites-Recu', [App\Http\Controllers\WEB\ActivitesControllerWeb::class, 'index'])->name('Activites_recu_web_index');
    Route::get('Activites-Deleguer', [App\Http\Controllers\WEB\ActivitesControllerWeb::class, 'index'])->name('Activites_deleguer_web_index');
    Route::get('Activites-besoins', [App\Http\Controllers\WEB\ActivitesControllerWeb::class, 'index'])->name('Activites_besoins_web_index');
    Route::get('Activites-objectifs', [App\Http\Controllers\WEB\ActivitesControllerWeb::class, 'index'])->name('Activites_objectifs_web_index');

    Route::get('/VALIDER', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_VALIDER_web_index');
    Route::get('/ENROLEMENTS', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_ENROLEMENTS_web_index');
    Route::get('/JOURNALS', function () {
        return view('/content/Journals.Journals');
    })->name('JOURNALS_web_index');
    Route::get('/VENTILATIONS', function () {
        return view('/content/Ventilations.Ventilations');
    })->name('Ventilations_web_index');
    Route::get('/DASHBOARD', function () {
        return view('/content/Homes.Homes');
    })->name('HOMES_web_index');

    Route::get('/Rapports', function () {
        return view('/content/Rapports.Rapports');
    })->name('Rapports_web_index');

    Route::get('/DECONNECTION', [AuthController::class, 'logout'])->name('LOGOUT_web_index');

    Route::get('Configurations', [App\Http\Controllers\WEB\ConfigurationsControllerWeb::class, 'index'])->name('Configurations_web_index');
});
// les routes prod
Route::group(['prefix' => '', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/Dashboard', [App\Http\Controllers\WEB\DashboardControllerWeb::class, 'index'])->name('Dashboard_web_index');
//Route::resource('Abscences',App\Http\Controllers\WEB\AbscencesControllerWeb::class);
    Route::get('Abscences', [App\Http\Controllers\WEB\AbscencesControllerWeb::class, 'index'])->name('Abscences_web_index');


    Route::get('Abscences/show/{Abscences}', [App\Http\Controllers\WEB\AbscencesControllerWeb::class, 'index_one'])->name('Abscences_web_index_one');


//Route::resource('Actifs',App\Http\Controllers\WEB\ActifsControllerWeb::class);
    Route::get('Actifs', [App\Http\Controllers\WEB\ActifsControllerWeb::class, 'index'])->name('Actifs_web_index');


    Route::get('Actifs/show/{Actifs}', [App\Http\Controllers\WEB\ActifsControllerWeb::class, 'index_one'])->name('Actifs_web_index_one');


//Route::resource('Actions',App\Http\Controllers\WEB\ActionsControllerWeb::class);
    Route::get('Actions', [App\Http\Controllers\WEB\ActionsControllerWeb::class, 'index'])->name('Actions_web_index');


    Route::get('Actions/show/{Actions}', [App\Http\Controllers\WEB\ActionsControllerWeb::class, 'index_one'])->name('Actions_web_index_one');


//Route::resource('Actionsprevisionelles',App\Http\Controllers\WEB\ActionsprevisionellesControllerWeb::class);
    Route::get('Actionsprevisionelles', [App\Http\Controllers\WEB\ActionsprevisionellesControllerWeb::class, 'index'])->name('Actionsprevisionelles_web_index');


    Route::get('Actionsprevisionelles/show/{Actionsprevisionelles}', [App\Http\Controllers\WEB\ActionsprevisionellesControllerWeb::class, 'index_one'])->name('Actionsprevisionelles_web_index_one');


//Route::resource('Actionsrealises',App\Http\Controllers\WEB\ActionsrealisesControllerWeb::class);
    Route::get('Actionsrealises', [App\Http\Controllers\WEB\ActionsrealisesControllerWeb::class, 'index'])->name('Actionsrealises_web_index');


    Route::get('Actionsrealises/show/{Actionsrealises}', [App\Http\Controllers\WEB\ActionsrealisesControllerWeb::class, 'index_one'])->name('Actionsrealises_web_index_one');


//Route::resource('Activites',App\Http\Controllers\WEB\ActivitesControllerWeb::class);
    Route::get('Activites', [App\Http\Controllers\WEB\ActivitesControllerWeb::class, 'index'])->name('Activites_web_index');


    Route::get('Activites/show/{Activites}', [App\Http\Controllers\WEB\ActivitesControllerWeb::class, 'index_one'])->name('Activites_web_index_one');


//Route::resource('Agentsrapports',App\Http\Controllers\WEB\AgentsrapportsControllerWeb::class);
    Route::get('Agentsrapports', [App\Http\Controllers\WEB\AgentsrapportsControllerWeb::class, 'index'])->name('Agentsrapports_web_index');


    Route::get('Agentsrapports/show/{Agentsrapports}', [App\Http\Controllers\WEB\AgentsrapportsControllerWeb::class, 'index_one'])->name('Agentsrapports_web_index_one');


//Route::resource('Alarms',App\Http\Controllers\WEB\AlarmsControllerWeb::class);
    Route::get('Alarms', [App\Http\Controllers\WEB\AlarmsControllerWeb::class, 'index'])->name('Alarms_web_index');


    Route::get('Alarms/show/{Alarms}', [App\Http\Controllers\WEB\AlarmsControllerWeb::class, 'index_one'])->name('Alarms_web_index_one');


//Route::resource('Alldatas',App\Http\Controllers\WEB\AlldatasControllerWeb::class);
    Route::get('Alldatas', [App\Http\Controllers\WEB\AlldatasControllerWeb::class, 'index'])->name('Alldatas_web_index');


    Route::get('Alldatas/show/{Alldatas}', [App\Http\Controllers\WEB\AlldatasControllerWeb::class, 'index_one'])->name('Alldatas_web_index_one');


//Route::resource('Analysespointeuses',App\Http\Controllers\WEB\AnalysespointeusesControllerWeb::class);
    Route::get('Analysespointeuses', [App\Http\Controllers\WEB\AnalysespointeusesControllerWeb::class, 'index'])->name('Analysespointeuses_web_index');


    Route::get('Analysespointeuses/show/{Analysespointeuses}', [App\Http\Controllers\WEB\AnalysespointeusesControllerWeb::class, 'index_one'])->name('Analysespointeuses_web_index_one');


//Route::resource('Approvisionementdetails',App\Http\Controllers\WEB\ApprovisionementdetailsControllerWeb::class);
    Route::get('Approvisionementdetails', [App\Http\Controllers\WEB\ApprovisionementdetailsControllerWeb::class, 'index'])->name('Approvisionementdetails_web_index');


    Route::get('Approvisionementdetails/show/{Approvisionementdetails}', [App\Http\Controllers\WEB\ApprovisionementdetailsControllerWeb::class, 'index_one'])->name('Approvisionementdetails_web_index_one');


//Route::resource('Approvisionements',App\Http\Controllers\WEB\ApprovisionementsControllerWeb::class);
    Route::get('Approvisionements', [App\Http\Controllers\WEB\ApprovisionementsControllerWeb::class, 'index'])->name('Approvisionements_web_index');


    Route::get('Approvisionements/show/{Approvisionements}', [App\Http\Controllers\WEB\ApprovisionementsControllerWeb::class, 'index_one'])->name('Approvisionements_web_index_one');


//Route::resource('Attributions',App\Http\Controllers\WEB\AttributionsControllerWeb::class);
    Route::get('Attributions', [App\Http\Controllers\WEB\AttributionsControllerWeb::class, 'index'])->name('Attributions_web_index');


    Route::get('Attributions/show/{Attributions}', [App\Http\Controllers\WEB\AttributionsControllerWeb::class, 'index_one'])->name('Attributions_web_index_one');


//Route::resource('Badges',App\Http\Controllers\WEB\BadgesControllerWeb::class);
    Route::get('Badges', [App\Http\Controllers\WEB\BadgesControllerWeb::class, 'index'])->name('Badges_web_index');


    Route::get('Badges/show/{Badges}', [App\Http\Controllers\WEB\BadgesControllerWeb::class, 'index_one'])->name('Badges_web_index_one');


//Route::resource('Balises',App\Http\Controllers\WEB\BalisesControllerWeb::class);
    Route::get('Balises', [App\Http\Controllers\WEB\BalisesControllerWeb::class, 'index'])->name('Balises_web_index');


    Route::get('Balises/show/{Balises}', [App\Http\Controllers\WEB\BalisesControllerWeb::class, 'index_one'])->name('Balises_web_index_one');


//Route::resource('Besoins',App\Http\Controllers\WEB\BesoinsControllerWeb::class);
    Route::get('Besoins', [App\Http\Controllers\WEB\BesoinsControllerWeb::class, 'index'])->name('Besoins_web_index');


    Route::get('Besoins/show/{Besoins}', [App\Http\Controllers\WEB\BesoinsControllerWeb::class, 'index_one'])->name('Besoins_web_index_one');


//Route::resource('Calendriers',App\Http\Controllers\WEB\CalendriersControllerWeb::class);
    Route::get('Calendriers', [App\Http\Controllers\WEB\CalendriersControllerWeb::class, 'index'])->name('Calendriers_web_index');


    Route::get('Calendriers/show/{Calendriers}', [App\Http\Controllers\WEB\CalendriersControllerWeb::class, 'index_one'])->name('Calendriers_web_index_one');


//Route::resource('Cartes',App\Http\Controllers\WEB\CartesControllerWeb::class);
    Route::get('Cartes', [App\Http\Controllers\WEB\CartesControllerWeb::class, 'index'])->name('Cartes_web_index');


    Route::get('Cartes/show/{Cartes}', [App\Http\Controllers\WEB\CartesControllerWeb::class, 'index_one'])->name('Cartes_web_index_one');


//Route::resource('Categories',App\Http\Controllers\WEB\CategoriesControllerWeb::class);
    Route::get('Categories', [App\Http\Controllers\WEB\CategoriesControllerWeb::class, 'index'])->name('Categories_web_index');


    Route::get('Categories/show/{Categories}', [App\Http\Controllers\WEB\CategoriesControllerWeb::class, 'index_one'])->name('Categories_web_index_one');


//Route::resource('Causeracines',App\Http\Controllers\WEB\CauseracinesControllerWeb::class);
    Route::get('Causeracines', [App\Http\Controllers\WEB\CauseracinesControllerWeb::class, 'index'])->name('Causeracines_web_index');


    Route::get('Causeracines/show/{Causeracines}', [App\Http\Controllers\WEB\CauseracinesControllerWeb::class, 'index_one'])->name('Causeracines_web_index_one');


//Route::resource('Chantierlocalisations',App\Http\Controllers\WEB\ChantierlocalisationsControllerWeb::class);
    Route::get('Chantierlocalisations', [App\Http\Controllers\WEB\ChantierlocalisationsControllerWeb::class, 'index'])->name('Chantierlocalisations_web_index');


    Route::get('Chantierlocalisations/show/{Chantierlocalisations}', [App\Http\Controllers\WEB\ChantierlocalisationsControllerWeb::class, 'index_one'])->name('Chantierlocalisations_web_index_one');


//Route::resource('Chantiers',App\Http\Controllers\WEB\ChantiersControllerWeb::class);
    Route::get('Chantiers', [App\Http\Controllers\WEB\ChantiersControllerWeb::class, 'index'])->name('Chantiers_web_index');


    Route::get('Chantiers/show/{Chantiers}', [App\Http\Controllers\WEB\ChantiersControllerWeb::class, 'index_one'])->name('Chantiers_web_index_one');


//Route::resource('Clients',App\Http\Controllers\WEB\ClientsControllerWeb::class);
    Route::get('Clients', [App\Http\Controllers\WEB\ClientsControllerWeb::class, 'index'])->name('Clients_web_index');


    Route::get('Clients/show/{Clients}', [App\Http\Controllers\WEB\ClientsControllerWeb::class, 'index_one'])->name('Clients_web_index_one');


//Route::resource('Configurations',App\Http\Controllers\WEB\ConfigurationsControllerWeb::class);
    Route::get('Configurations', [App\Http\Controllers\WEB\ConfigurationsControllerWeb::class, 'index'])->name('Configurations_web_index');


    Route::get('Configurations/show/{Configurations}', [App\Http\Controllers\WEB\ConfigurationsControllerWeb::class, 'index_one'])->name('Configurations_web_index_one');


//Route::resource('Conges',App\Http\Controllers\WEB\CongesControllerWeb::class);
    Route::get('Conges', [App\Http\Controllers\WEB\CongesControllerWeb::class, 'index'])->name('Conges_web_index');


    Route::get('Conges/show/{Conges}', [App\Http\Controllers\WEB\CongesControllerWeb::class, 'index_one'])->name('Conges_web_index_one');


//Route::resource('Contrats',App\Http\Controllers\WEB\ContratsControllerWeb::class);
    Route::get('Contrats', [App\Http\Controllers\WEB\ContratsControllerWeb::class, 'index'])->name('Contrats_web_index');


    Route::get('Contrats/show/{Contrats}', [App\Http\Controllers\WEB\ContratsControllerWeb::class, 'index_one'])->name('Contrats_web_index_one');


//Route::resource('Contratsagents',App\Http\Controllers\WEB\ContratsagentsControllerWeb::class);
    Route::get('Contratsagents', [App\Http\Controllers\WEB\ContratsagentsControllerWeb::class, 'index'])->name('Contratsagents_web_index');


    Route::get('Contratsagents/show/{Contratsagents}', [App\Http\Controllers\WEB\ContratsagentsControllerWeb::class, 'index_one'])->name('Contratsagents_web_index_one');


//Route::resource('Contratsclients',App\Http\Controllers\WEB\ContratsclientsControllerWeb::class);
    Route::get('Contratsclients', [App\Http\Controllers\WEB\ContratsclientsControllerWeb::class, 'index'])->name('Contratsclients_web_index');


    Route::get('Contratsclients/show/{Contratsclients}', [App\Http\Controllers\WEB\ContratsclientsControllerWeb::class, 'index_one'])->name('Contratsclients_web_index_one');


//Route::resource('Contratspostes',App\Http\Controllers\WEB\ContratspostesControllerWeb::class);
    Route::get('Contratspostes', [App\Http\Controllers\WEB\ContratspostesControllerWeb::class, 'index'])->name('Contratspostes_web_index');


    Route::get('Contratspostes/show/{Contratspostes}', [App\Http\Controllers\WEB\ContratspostesControllerWeb::class, 'index_one'])->name('Contratspostes_web_index_one');


//Route::resource('Contratssites',App\Http\Controllers\WEB\ContratssitesControllerWeb::class);
    Route::get('Contratssites', [App\Http\Controllers\WEB\ContratssitesControllerWeb::class, 'index'])->name('Contratssites_web_index');


    Route::get('Contratssites/show/{Contratssites}', [App\Http\Controllers\WEB\ContratssitesControllerWeb::class, 'index_one'])->name('Contratssites_web_index_one');


//Route::resource('Controlleursacces',App\Http\Controllers\WEB\ControlleursaccesControllerWeb::class);
    Route::get('Controlleursacces', [App\Http\Controllers\WEB\ControlleursaccesControllerWeb::class, 'index'])->name('Controlleursacces_web_index');


    Route::get('Controlleursacces/show/{Controlleursacces}', [App\Http\Controllers\WEB\ControlleursaccesControllerWeb::class, 'index_one'])->name('Controlleursacces_web_index_one');


//Route::resource('Credits',App\Http\Controllers\WEB\CreditsControllerWeb::class);
    Route::get('Credits', [App\Http\Controllers\WEB\CreditsControllerWeb::class, 'index'])->name('Credits_web_index');


    Route::get('Credits/show/{Credits}', [App\Http\Controllers\WEB\CreditsControllerWeb::class, 'index_one'])->name('Credits_web_index_one');


//Route::resource('Cruds',App\Http\Controllers\WEB\CrudsControllerWeb::class);
    Route::get('Cruds', [App\Http\Controllers\WEB\CrudsControllerWeb::class, 'index'])->name('Cruds_web_index');


    Route::get('Cruds/show/{Cruds}', [App\Http\Controllers\WEB\CrudsControllerWeb::class, 'index_one'])->name('Cruds_web_index_one');


//Route::resource('Debits',App\Http\Controllers\WEB\DebitsControllerWeb::class);
    Route::get('Debits', [App\Http\Controllers\WEB\DebitsControllerWeb::class, 'index'])->name('Debits_web_index');


    Route::get('Debits/show/{Debits}', [App\Http\Controllers\WEB\DebitsControllerWeb::class, 'index_one'])->name('Debits_web_index_one');


//Route::resource('Dependances',App\Http\Controllers\WEB\DependancesControllerWeb::class);
    Route::get('Dependances', [App\Http\Controllers\WEB\DependancesControllerWeb::class, 'index'])->name('Dependances_web_index');


    Route::get('Dependances/show/{Dependances}', [App\Http\Controllers\WEB\DependancesControllerWeb::class, 'index_one'])->name('Dependances_web_index_one');


//Route::resource('Deplacements',App\Http\Controllers\WEB\DeplacementsControllerWeb::class);
    Route::get('Deplacements', [App\Http\Controllers\WEB\DeplacementsControllerWeb::class, 'index'])->name('Deplacements_web_index');


    Route::get('Deplacements/show/{Deplacements}', [App\Http\Controllers\WEB\DeplacementsControllerWeb::class, 'index_one'])->name('Deplacements_web_index_one');


//Route::resource('Details',App\Http\Controllers\WEB\DetailsControllerWeb::class);
    Route::get('Details', [App\Http\Controllers\WEB\DetailsControllerWeb::class, 'index'])->name('Details_web_index');


    Route::get('Details/show/{Details}', [App\Http\Controllers\WEB\DetailsControllerWeb::class, 'index_one'])->name('Details_web_index_one');


//Route::resource('Directions',App\Http\Controllers\WEB\DirectionsControllerWeb::class);
    Route::get('Directions', [App\Http\Controllers\WEB\DirectionsControllerWeb::class, 'index'])->name('Directions_web_index');


    Route::get('Directions/show/{Directions}', [App\Http\Controllers\WEB\DirectionsControllerWeb::class, 'index_one'])->name('Directions_web_index_one');


//Route::resource('Documents',App\Http\Controllers\WEB\DocumentsControllerWeb::class);
    Route::get('Documents', [App\Http\Controllers\WEB\DocumentsControllerWeb::class, 'index'])->name('Documents_web_index');


    Route::get('Documents/show/{Documents}', [App\Http\Controllers\WEB\DocumentsControllerWeb::class, 'index_one'])->name('Documents_web_index_one');


//Route::resource('DoublonsPostes',App\Http\Controllers\WEB\DoublonsPostesControllerWeb::class);
    Route::get('DoublonsPostes', [App\Http\Controllers\WEB\DoublonsPostesControllerWeb::class, 'index'])->name('DoublonsPostes_web_index');


    Route::get('DoublonsPostes/show/{DoublonsPostes}', [App\Http\Controllers\WEB\DoublonsPostesControllerWeb::class, 'index_one'])->name('DoublonsPostes_web_index_one');


//Route::resource('Echelons',App\Http\Controllers\WEB\EchelonsControllerWeb::class);
    Route::get('Echelons', [App\Http\Controllers\WEB\EchelonsControllerWeb::class, 'index'])->name('Echelons_web_index');


    Route::get('Echelons/show/{Echelons}', [App\Http\Controllers\WEB\EchelonsControllerWeb::class, 'index_one'])->name('Echelons_web_index_one');


//Route::resource('Ecouteurs',App\Http\Controllers\WEB\EcouteursControllerWeb::class);
    Route::get('Ecouteurs', [App\Http\Controllers\WEB\EcouteursControllerWeb::class, 'index'])->name('Ecouteurs_web_index');


    Route::get('Ecouteurs/show/{Ecouteurs}', [App\Http\Controllers\WEB\EcouteursControllerWeb::class, 'index_one'])->name('Ecouteurs_web_index_one');


//Route::resource('Empreintes',App\Http\Controllers\WEB\EmpreintesControllerWeb::class);
    Route::get('Empreintes', [App\Http\Controllers\WEB\EmpreintesControllerWeb::class, 'index'])->name('Empreintes_web_index');


    Route::get('Empreintes/show/{Empreintes}', [App\Http\Controllers\WEB\EmpreintesControllerWeb::class, 'index_one'])->name('Empreintes_web_index_one');


//Route::resource('Entreprises',App\Http\Controllers\WEB\EntreprisesControllerWeb::class);
    Route::get('Entreprises', [App\Http\Controllers\WEB\EntreprisesControllerWeb::class, 'index'])->name('Entreprises_web_index');


    Route::get('Entreprises/show/{Entreprises}', [App\Http\Controllers\WEB\EntreprisesControllerWeb::class, 'index_one'])->name('Entreprises_web_index_one');


//Route::resource('Etapes',App\Http\Controllers\WEB\EtapesControllerWeb::class);
    Route::get('Etapes', [App\Http\Controllers\WEB\EtapesControllerWeb::class, 'index'])->name('Etapes_web_index');


    Route::get('Etapes/show/{Etapes}', [App\Http\Controllers\WEB\EtapesControllerWeb::class, 'index_one'])->name('Etapes_web_index_one');


//Route::resource('Exports',App\Http\Controllers\WEB\ExportsControllerWeb::class);
    Route::get('Exports', [App\Http\Controllers\WEB\ExportsControllerWeb::class, 'index'])->name('Exports_web_index');


    Route::get('Exports/show/{Exports}', [App\Http\Controllers\WEB\ExportsControllerWeb::class, 'index_one'])->name('Exports_web_index_one');


//Route::resource('Exportsdetails',App\Http\Controllers\WEB\ExportsdetailsControllerWeb::class);
    Route::get('Exportsdetails', [App\Http\Controllers\WEB\ExportsdetailsControllerWeb::class, 'index'])->name('Exportsdetails_web_index');


    Route::get('Exportsdetails/show/{Exportsdetails}', [App\Http\Controllers\WEB\ExportsdetailsControllerWeb::class, 'index_one'])->name('Exportsdetails_web_index_one');


//Route::resource('Extrasdatas',App\Http\Controllers\WEB\ExtrasdatasControllerWeb::class);
    Route::get('Extrasdatas', [App\Http\Controllers\WEB\ExtrasdatasControllerWeb::class, 'index'])->name('Extrasdatas_web_index');


    Route::get('Extrasdatas/show/{Extrasdatas}', [App\Http\Controllers\WEB\ExtrasdatasControllerWeb::class, 'index_one'])->name('Extrasdatas_web_index_one');


//Route::resource('Factions',App\Http\Controllers\WEB\FactionsControllerWeb::class);
    Route::get('Factions', [App\Http\Controllers\WEB\FactionsControllerWeb::class, 'index'])->name('Factions_web_index');


    Route::get('Factions/show/{Factions}', [App\Http\Controllers\WEB\FactionsControllerWeb::class, 'index_one'])->name('Factions_web_index_one');


//Route::resource('Facturationuploads',App\Http\Controllers\WEB\FacturationuploadsControllerWeb::class);
    Route::get('Facturationuploads', [App\Http\Controllers\WEB\FacturationuploadsControllerWeb::class, 'index'])->name('Facturationuploads_web_index');


    Route::get('Facturationuploads/show/{Facturationuploads}', [App\Http\Controllers\WEB\FacturationuploadsControllerWeb::class, 'index_one'])->name('Facturationuploads_web_index_one');


//Route::resource('Files',App\Http\Controllers\WEB\FilesControllerWeb::class);
    Route::get('Files', [App\Http\Controllers\WEB\FilesControllerWeb::class, 'index'])->name('Files_web_index');


    Route::get('Files/show/{Files}', [App\Http\Controllers\WEB\FilesControllerWeb::class, 'index_one'])->name('Files_web_index_one');


//Route::resource('Fonctions',App\Http\Controllers\WEB\FonctionsControllerWeb::class);
    Route::get('Fonctions', [App\Http\Controllers\WEB\FonctionsControllerWeb::class, 'index'])->name('Fonctions_web_index');


    Route::get('Fonctions/show/{Fonctions}', [App\Http\Controllers\WEB\FonctionsControllerWeb::class, 'index_one'])->name('Fonctions_web_index_one');


//Route::resource('Forms',App\Http\Controllers\WEB\FormsControllerWeb::class);
    Route::get('Forms', [App\Http\Controllers\WEB\FormsControllerWeb::class, 'index'])->name('Forms_web_index');


    Route::get('Forms/show/{Forms}', [App\Http\Controllers\WEB\FormsControllerWeb::class, 'index_one'])->name('Forms_web_index_one');


//Route::resource('Formschamps',App\Http\Controllers\WEB\FormschampsControllerWeb::class);
    Route::get('Formschamps', [App\Http\Controllers\WEB\FormschampsControllerWeb::class, 'index'])->name('Formschamps_web_index');


    Route::get('Formschamps/show/{Formschamps}', [App\Http\Controllers\WEB\FormschampsControllerWeb::class, 'index_one'])->name('Formschamps_web_index_one');


//Route::resource('Formsdatas',App\Http\Controllers\WEB\FormsdatasControllerWeb::class);
    Route::get('Formsdatas', [App\Http\Controllers\WEB\FormsdatasControllerWeb::class, 'index'])->name('Formsdatas_web_index');


    Route::get('Formsdatas/show/{Formsdatas}', [App\Http\Controllers\WEB\FormsdatasControllerWeb::class, 'index_one'])->name('Formsdatas_web_index_one');


//Route::resource('Graphiques',App\Http\Controllers\WEB\GraphiquesControllerWeb::class);
    Route::get('Graphiques', [App\Http\Controllers\WEB\GraphiquesControllerWeb::class, 'index'])->name('Graphiques_web_index');


    Route::get('Graphiques/show/{Graphiques}', [App\Http\Controllers\WEB\GraphiquesControllerWeb::class, 'index_one'])->name('Graphiques_web_index_one');


//Route::resource('Groupedirections',App\Http\Controllers\WEB\GroupedirectionsControllerWeb::class);
    Route::get('Groupedirections', [App\Http\Controllers\WEB\GroupedirectionsControllerWeb::class, 'index'])->name('Groupedirections_web_index');


    Route::get('Groupedirections/show/{Groupedirections}', [App\Http\Controllers\WEB\GroupedirectionsControllerWeb::class, 'index_one'])->name('Groupedirections_web_index_one');


//Route::resource('Groupepermissions',App\Http\Controllers\WEB\GroupepermissionsControllerWeb::class);
    Route::get('Groupepermissions', [App\Http\Controllers\WEB\GroupepermissionsControllerWeb::class, 'index'])->name('Groupepermissions_web_index');


    Route::get('Groupepermissions/show/{Groupepermissions}', [App\Http\Controllers\WEB\GroupepermissionsControllerWeb::class, 'index_one'])->name('Groupepermissions_web_index_one');


//Route::resource('Historiquemodelslistings',App\Http\Controllers\WEB\HistoriquemodelslistingsControllerWeb::class);
    Route::get('Historiquemodelslistings', [App\Http\Controllers\WEB\HistoriquemodelslistingsControllerWeb::class, 'index'])->name('Historiquemodelslistings_web_index');


    Route::get('Historiquemodelslistings/show/{Historiquemodelslistings}', [App\Http\Controllers\WEB\HistoriquemodelslistingsControllerWeb::class, 'index_one'])->name('Historiquemodelslistings_web_index_one');


//Route::resource('Historiques',App\Http\Controllers\WEB\HistoriquesControllerWeb::class);
    Route::get('Historiques', [App\Http\Controllers\WEB\HistoriquesControllerWeb::class, 'index'])->name('Historiques_web_index');


    Route::get('Historiques/show/{Historiques}', [App\Http\Controllers\WEB\HistoriquesControllerWeb::class, 'index_one'])->name('Historiques_web_index_one');


//Route::resource('Homes',App\Http\Controllers\WEB\HomesControllerWeb::class);
    Route::get('Homes', [App\Http\Controllers\WEB\HomesControllerWeb::class, 'index'])->name('Homes_web_index');


    Route::get('Homes/show/{Homes}', [App\Http\Controllers\WEB\HomesControllerWeb::class, 'index_one'])->name('Homes_web_index_one');


//Route::resource('Homezones',App\Http\Controllers\WEB\HomezonesControllerWeb::class);
    Route::get('Homezones', [App\Http\Controllers\WEB\HomezonesControllerWeb::class, 'index'])->name('Homezones_web_index');


    Route::get('Homezones/show/{Homezones}', [App\Http\Controllers\WEB\HomezonesControllerWeb::class, 'index_one'])->name('Homezones_web_index_one');


//Route::resource('Horaireagents',App\Http\Controllers\WEB\HoraireagentsControllerWeb::class);
    Route::get('Horaireagents', [App\Http\Controllers\WEB\HoraireagentsControllerWeb::class, 'index'])->name('Horaireagents_web_index');


    Route::get('Horaireagents/show/{Horaireagents}', [App\Http\Controllers\WEB\HoraireagentsControllerWeb::class, 'index_one'])->name('Horaireagents_web_index_one');


//Route::resource('Horaires',App\Http\Controllers\WEB\HorairesControllerWeb::class);
    Route::get('Horaires', [App\Http\Controllers\WEB\HorairesControllerWeb::class, 'index'])->name('Horaires_web_index');


    Route::get('Horaires/show/{Horaires}', [App\Http\Controllers\WEB\HorairesControllerWeb::class, 'index_one'])->name('Horaires_web_index_one');


//Route::resource('Horairesglobals',App\Http\Controllers\WEB\HorairesglobalsControllerWeb::class);
    Route::get('Horairesglobals', [App\Http\Controllers\WEB\HorairesglobalsControllerWeb::class, 'index'])->name('Horairesglobals_web_index');


    Route::get('Horairesglobals/show/{Horairesglobals}', [App\Http\Controllers\WEB\HorairesglobalsControllerWeb::class, 'index_one'])->name('Horairesglobals_web_index_one');


//Route::resource('Horairesglobalspostes',App\Http\Controllers\WEB\HorairesglobalspostesControllerWeb::class);
    Route::get('Horairesglobalspostes', [App\Http\Controllers\WEB\HorairesglobalspostesControllerWeb::class, 'index'])->name('Horairesglobalspostes_web_index');


    Route::get('Horairesglobalspostes/show/{Horairesglobalspostes}', [App\Http\Controllers\WEB\HorairesglobalspostesControllerWeb::class, 'index_one'])->name('Horairesglobalspostes_web_index_one');


//Route::resource('Horairesglobalstaches',App\Http\Controllers\WEB\HorairesglobalstachesControllerWeb::class);
    Route::get('Horairesglobalstaches', [App\Http\Controllers\WEB\HorairesglobalstachesControllerWeb::class, 'index'])->name('Horairesglobalstaches_web_index');


    Route::get('Horairesglobalstaches/show/{Horairesglobalstaches}', [App\Http\Controllers\WEB\HorairesglobalstachesControllerWeb::class, 'index_one'])->name('Horairesglobalstaches_web_index_one');


//Route::resource('Horairestypespostes',App\Http\Controllers\WEB\HorairestypespostesControllerWeb::class);
    Route::get('Horairestypespostes', [App\Http\Controllers\WEB\HorairestypespostesControllerWeb::class, 'index'])->name('Horairestypespostes_web_index');


    Route::get('Horairestypespostes/show/{Horairestypespostes}', [App\Http\Controllers\WEB\HorairestypespostesControllerWeb::class, 'index_one'])->name('Horairestypespostes_web_index_one');


//Route::resource('Horairestypessites',App\Http\Controllers\WEB\HorairestypessitesControllerWeb::class);
    Route::get('Horairestypessites', [App\Http\Controllers\WEB\HorairestypessitesControllerWeb::class, 'index'])->name('Horairestypessites_web_index');


    Route::get('Horairestypessites/show/{Horairestypessites}', [App\Http\Controllers\WEB\HorairestypessitesControllerWeb::class, 'index_one'])->name('Horairestypessites_web_index_one');


//Route::resource('Identifications',App\Http\Controllers\WEB\IdentificationsControllerWeb::class);
    Route::get('Identifications', [App\Http\Controllers\WEB\IdentificationsControllerWeb::class, 'index'])->name('Identifications_web_index');


    Route::get('Identifications/show/{Identifications}', [App\Http\Controllers\WEB\IdentificationsControllerWeb::class, 'index_one'])->name('Identifications_web_index_one');


//Route::resource('Imports',App\Http\Controllers\WEB\ImportsControllerWeb::class);
    Route::get('Imports', [App\Http\Controllers\WEB\ImportsControllerWeb::class, 'index'])->name('Imports_web_index');


    Route::get('Imports/show/{Imports}', [App\Http\Controllers\WEB\ImportsControllerWeb::class, 'index_one'])->name('Imports_web_index_one');


//Route::resource('Interventiondetails',App\Http\Controllers\WEB\InterventiondetailsControllerWeb::class);
    Route::get('Interventiondetails', [App\Http\Controllers\WEB\InterventiondetailsControllerWeb::class, 'index'])->name('Interventiondetails_web_index');


    Route::get('Interventiondetails/show/{Interventiondetails}', [App\Http\Controllers\WEB\InterventiondetailsControllerWeb::class, 'index_one'])->name('Interventiondetails_web_index_one');


//Route::resource('Interventionimages',App\Http\Controllers\WEB\InterventionimagesControllerWeb::class);
    Route::get('Interventionimages', [App\Http\Controllers\WEB\InterventionimagesControllerWeb::class, 'index'])->name('Interventionimages_web_index');


    Route::get('Interventionimages/show/{Interventionimages}', [App\Http\Controllers\WEB\InterventionimagesControllerWeb::class, 'index_one'])->name('Interventionimages_web_index_one');


//Route::resource('Interventions',App\Http\Controllers\WEB\InterventionsControllerWeb::class);
    Route::get('Interventions', [App\Http\Controllers\WEB\InterventionsControllerWeb::class, 'index'])->name('Interventions_web_index');


    Route::get('Interventions/show/{Interventions}', [App\Http\Controllers\WEB\InterventionsControllerWeb::class, 'index_one'])->name('Interventions_web_index_one');


//Route::resource('Interventionusers',App\Http\Controllers\WEB\InterventionusersControllerWeb::class);
    Route::get('Interventionusers', [App\Http\Controllers\WEB\InterventionusersControllerWeb::class, 'index'])->name('Interventionusers_web_index');


    Route::get('Interventionusers/show/{Interventionusers}', [App\Http\Controllers\WEB\InterventionusersControllerWeb::class, 'index_one'])->name('Interventionusers_web_index_one');


//Route::resource('Jobs',App\Http\Controllers\WEB\JobsControllerWeb::class);
    Route::get('Jobs', [App\Http\Controllers\WEB\JobsControllerWeb::class, 'index'])->name('Jobs_web_index');


    Route::get('Jobs/show/{Jobs}', [App\Http\Controllers\WEB\JobsControllerWeb::class, 'index_one'])->name('Jobs_web_index_one');


//Route::resource('Joursferies',App\Http\Controllers\WEB\JoursferiesControllerWeb::class);
    Route::get('Joursferies', [App\Http\Controllers\WEB\JoursferiesControllerWeb::class, 'index'])->name('Joursferies_web_index');


    Route::get('Joursferies/show/{Joursferies}', [App\Http\Controllers\WEB\JoursferiesControllerWeb::class, 'index_one'])->name('Joursferies_web_index_one');


//Route::resource('Lignes',App\Http\Controllers\WEB\LignesControllerWeb::class);
    Route::get('Lignes', [App\Http\Controllers\WEB\LignesControllerWeb::class, 'index'])->name('Lignes_web_index');


    Route::get('Lignes/show/{Lignes}', [App\Http\Controllers\WEB\LignesControllerWeb::class, 'index_one'])->name('Lignes_web_index_one');


//Route::resource('Lignesmoyenstransports',App\Http\Controllers\WEB\LignesmoyenstransportsControllerWeb::class);
    Route::get('Lignesmoyenstransports', [App\Http\Controllers\WEB\LignesmoyenstransportsControllerWeb::class, 'index'])->name('Lignesmoyenstransports_web_index');


    Route::get('Lignesmoyenstransports/show/{Lignesmoyenstransports}', [App\Http\Controllers\WEB\LignesmoyenstransportsControllerWeb::class, 'index_one'])->name('Lignesmoyenstransports_web_index_one');


//Route::resource('Listesappels',App\Http\Controllers\WEB\ListesappelsControllerWeb::class);
    Route::get('Listesappels', [App\Http\Controllers\WEB\ListesappelsControllerWeb::class, 'index'])->name('Listesappels_web_index');


    Route::get('Listesappels/show/{Listesappels}', [App\Http\Controllers\WEB\ListesappelsControllerWeb::class, 'index_one'])->name('Listesappels_web_index_one');


//Route::resource('Listesappelsjours',App\Http\Controllers\WEB\ListesappelsjoursControllerWeb::class);
    Route::get('Listesappelsjours', [App\Http\Controllers\WEB\ListesappelsjoursControllerWeb::class, 'index'])->name('Listesappelsjours_web_index');


    Route::get('Listesappelsjours/show/{Listesappelsjours}', [App\Http\Controllers\WEB\ListesappelsjoursControllerWeb::class, 'index_one'])->name('Listesappelsjours_web_index_one');


//Route::resource('Listesjours',App\Http\Controllers\WEB\ListesjoursControllerWeb::class);
    Route::get('Listesjours', [App\Http\Controllers\WEB\ListesjoursControllerWeb::class, 'index'])->name('Listesjours_web_index');


    Route::get('Listesjours/show/{Listesjours}', [App\Http\Controllers\WEB\ListesjoursControllerWeb::class, 'index_one'])->name('Listesjours_web_index_one');


//Route::resource('Listings',App\Http\Controllers\WEB\ListingsControllerWeb::class);
    Route::get('Listings', [App\Http\Controllers\WEB\ListingsControllerWeb::class, 'index'])->name('Listings_web_index');


    Route::get('Listings/show/{Listings}', [App\Http\Controllers\WEB\ListingsControllerWeb::class, 'index_one'])->name('Listings_web_index_one');


//Route::resource('Listingsetats',App\Http\Controllers\WEB\ListingsetatsControllerWeb::class);
    Route::get('Listingsetats', [App\Http\Controllers\WEB\ListingsetatsControllerWeb::class, 'index'])->name('Listingsetats_web_index');


    Route::get('Listingsetats/show/{Listingsetats}', [App\Http\Controllers\WEB\ListingsetatsControllerWeb::class, 'index_one'])->name('Listingsetats_web_index_one');


//Route::resource('Listingsjours',App\Http\Controllers\WEB\ListingsjoursControllerWeb::class);
    Route::get('Listingsjours', [App\Http\Controllers\WEB\ListingsjoursControllerWeb::class, 'index'])->name('Listingsjours_web_index');


    Route::get('Listingsjours/show/{Listingsjours}', [App\Http\Controllers\WEB\ListingsjoursControllerWeb::class, 'index_one'])->name('Listingsjours_web_index_one');


//Route::resource('Listingsvalider0stats',App\Http\Controllers\WEB\Listingsvalider0statsControllerWeb::class);
    Route::get('Listingsvalider0stats', [App\Http\Controllers\WEB\Listingsvalider0statsControllerWeb::class, 'index'])->name('Listingsvalider0stats_web_index');


    Route::get('Listingsvalider0stats/show/{Listingsvalider0stats}', [App\Http\Controllers\WEB\Listingsvalider0statsControllerWeb::class, 'index_one'])->name('Listingsvalider0stats_web_index_one');


//Route::resource('Listingsvalider1stats',App\Http\Controllers\WEB\Listingsvalider1statsControllerWeb::class);
    Route::get('Listingsvalider1stats', [App\Http\Controllers\WEB\Listingsvalider1statsControllerWeb::class, 'index'])->name('Listingsvalider1stats_web_index');


    Route::get('Listingsvalider1stats/show/{Listingsvalider1stats}', [App\Http\Controllers\WEB\Listingsvalider1statsControllerWeb::class, 'index_one'])->name('Listingsvalider1stats_web_index_one');


//Route::resource('Listingsvalider2stats',App\Http\Controllers\WEB\Listingsvalider2statsControllerWeb::class);
    Route::get('Listingsvalider2stats', [App\Http\Controllers\WEB\Listingsvalider2statsControllerWeb::class, 'index'])->name('Listingsvalider2stats_web_index');


    Route::get('Listingsvalider2stats/show/{Listingsvalider2stats}', [App\Http\Controllers\WEB\Listingsvalider2statsControllerWeb::class, 'index_one'])->name('Listingsvalider2stats_web_index_one');


//Route::resource('Logins',App\Http\Controllers\WEB\LoginsControllerWeb::class);
    Route::get('Logins', [App\Http\Controllers\WEB\LoginsControllerWeb::class, 'index'])->name('Logins_web_index');


    Route::get('Logins/show/{Logins}', [App\Http\Controllers\WEB\LoginsControllerWeb::class, 'index_one'])->name('Logins_web_index_one');


//Route::resource('Logs',App\Http\Controllers\WEB\LogsControllerWeb::class);
    Route::get('Logs', [App\Http\Controllers\WEB\LogsControllerWeb::class, 'index'])->name('Logs_web_index');


    Route::get('Logs/show/{Logs}', [App\Http\Controllers\WEB\LogsControllerWeb::class, 'index_one'])->name('Logs_web_index_one');


//Route::resource('Materielinterventiondetails',App\Http\Controllers\WEB\MaterielinterventiondetailsControllerWeb::class);
    Route::get('Materielinterventiondetails', [App\Http\Controllers\WEB\MaterielinterventiondetailsControllerWeb::class, 'index'])->name('Materielinterventiondetails_web_index');


    Route::get('Materielinterventiondetails/show/{Materielinterventiondetails}', [App\Http\Controllers\WEB\MaterielinterventiondetailsControllerWeb::class, 'index_one'])->name('Materielinterventiondetails_web_index_one');


//Route::resource('Materielinterventions',App\Http\Controllers\WEB\MaterielinterventionsControllerWeb::class);
    Route::get('Materielinterventions', [App\Http\Controllers\WEB\MaterielinterventionsControllerWeb::class, 'index'])->name('Materielinterventions_web_index');


    Route::get('Materielinterventions/show/{Materielinterventions}', [App\Http\Controllers\WEB\MaterielinterventionsControllerWeb::class, 'index_one'])->name('Materielinterventions_web_index_one');


//Route::resource('Materielprevisionnels',App\Http\Controllers\WEB\MaterielprevisionnelsControllerWeb::class);
    Route::get('Materielprevisionnels', [App\Http\Controllers\WEB\MaterielprevisionnelsControllerWeb::class, 'index'])->name('Materielprevisionnels_web_index');


    Route::get('Materielprevisionnels/show/{Materielprevisionnels}', [App\Http\Controllers\WEB\MaterielprevisionnelsControllerWeb::class, 'index_one'])->name('Materielprevisionnels_web_index_one');


//Route::resource('Materiels',App\Http\Controllers\WEB\MaterielsControllerWeb::class);
    Route::get('Materiels', [App\Http\Controllers\WEB\MaterielsControllerWeb::class, 'index'])->name('Materiels_web_index');


    Route::get('Materiels/show/{Materiels}', [App\Http\Controllers\WEB\MaterielsControllerWeb::class, 'index_one'])->name('Materiels_web_index_one');


//Route::resource('Matrices',App\Http\Controllers\WEB\MatricesControllerWeb::class);
    Route::get('Matrices', [App\Http\Controllers\WEB\MatricesControllerWeb::class, 'index'])->name('Matrices_web_index');


    Route::get('Matrices/show/{Matrices}', [App\Http\Controllers\WEB\MatricesControllerWeb::class, 'index_one'])->name('Matrices_web_index_one');


//Route::resource('Matrimoniales',App\Http\Controllers\WEB\MatrimonialesControllerWeb::class);
    Route::get('Matrimoniales', [App\Http\Controllers\WEB\MatrimonialesControllerWeb::class, 'index'])->name('Matrimoniales_web_index');


    Route::get('Matrimoniales/show/{Matrimoniales}', [App\Http\Controllers\WEB\MatrimonialesControllerWeb::class, 'index_one'])->name('Matrimoniales_web_index_one');


//Route::resource('Menus',App\Http\Controllers\WEB\MenusControllerWeb::class);
    Route::get('Menus', [App\Http\Controllers\WEB\MenusControllerWeb::class, 'index'])->name('Menus_web_index');


    Route::get('Menus/show/{Menus}', [App\Http\Controllers\WEB\MenusControllerWeb::class, 'index_one'])->name('Menus_web_index_one');


//Route::resource('Mesurespreventives',App\Http\Controllers\WEB\MesurespreventivesControllerWeb::class);
    Route::get('Mesurespreventives', [App\Http\Controllers\WEB\MesurespreventivesControllerWeb::class, 'index'])->name('Mesurespreventives_web_index');


    Route::get('Mesurespreventives/show/{Mesurespreventives}', [App\Http\Controllers\WEB\MesurespreventivesControllerWeb::class, 'index_one'])->name('Mesurespreventives_web_index_one');


//Route::resource('Model_has_permissions',App\Http\Controllers\WEB\Model_has_permissionsControllerWeb::class);
    Route::get('Model_has_permissions', [App\Http\Controllers\WEB\Model_has_permissionsControllerWeb::class, 'index'])->name('Model_has_permissions_web_index');


    Route::get('Model_has_permissions/show/{Model_has_permissions}', [App\Http\Controllers\WEB\Model_has_permissionsControllerWeb::class, 'index_one'])->name('Model_has_permissions_web_index_one');


//Route::resource('Model_has_roles',App\Http\Controllers\WEB\Model_has_rolesControllerWeb::class);
    Route::get('Model_has_roles', [App\Http\Controllers\WEB\Model_has_rolesControllerWeb::class, 'index'])->name('Model_has_roles_web_index');


    Route::get('Model_has_roles/show/{Model_has_roles}', [App\Http\Controllers\WEB\Model_has_rolesControllerWeb::class, 'index_one'])->name('Model_has_roles_web_index_one');


//Route::resource('Modelslistings',App\Http\Controllers\WEB\ModelslistingsControllerWeb::class);
    Route::get('Modelslistings', [App\Http\Controllers\WEB\ModelslistingsControllerWeb::class, 'index'])->name('Modelslistings_web_index');


    Route::get('Modelslistings/show/{Modelslistings}', [App\Http\Controllers\WEB\ModelslistingsControllerWeb::class, 'index_one'])->name('Modelslistings_web_index_one');


//Route::resource('Moyenstransports',App\Http\Controllers\WEB\MoyenstransportsControllerWeb::class);
    Route::get('Moyenstransports', [App\Http\Controllers\WEB\MoyenstransportsControllerWeb::class, 'index'])->name('Moyenstransports_web_index');


    Route::get('Moyenstransports/show/{Moyenstransports}', [App\Http\Controllers\WEB\MoyenstransportsControllerWeb::class, 'index_one'])->name('Moyenstransports_web_index_one');


//Route::resource('Nationalites',App\Http\Controllers\WEB\NationalitesControllerWeb::class);
    Route::get('Nationalites', [App\Http\Controllers\WEB\NationalitesControllerWeb::class, 'index'])->name('Nationalites_web_index');


    Route::get('Nationalites/show/{Nationalites}', [App\Http\Controllers\WEB\NationalitesControllerWeb::class, 'index_one'])->name('Nationalites_web_index_one');


//Route::resource('Oauth_access_tokens',App\Http\Controllers\WEB\Oauth_access_tokensControllerWeb::class);
    Route::get('Oauth_access_tokens', [App\Http\Controllers\WEB\Oauth_access_tokensControllerWeb::class, 'index'])->name('Oauth_access_tokens_web_index');


    Route::get('Oauth_access_tokens/show/{Oauth_access_tokens}', [App\Http\Controllers\WEB\Oauth_access_tokensControllerWeb::class, 'index_one'])->name('Oauth_access_tokens_web_index_one');


//Route::resource('Oauth_auth_codes',App\Http\Controllers\WEB\Oauth_auth_codesControllerWeb::class);
    Route::get('Oauth_auth_codes', [App\Http\Controllers\WEB\Oauth_auth_codesControllerWeb::class, 'index'])->name('Oauth_auth_codes_web_index');


    Route::get('Oauth_auth_codes/show/{Oauth_auth_codes}', [App\Http\Controllers\WEB\Oauth_auth_codesControllerWeb::class, 'index_one'])->name('Oauth_auth_codes_web_index_one');


//Route::resource('Oauth_clients',App\Http\Controllers\WEB\Oauth_clientsControllerWeb::class);
    Route::get('Oauth_clients', [App\Http\Controllers\WEB\Oauth_clientsControllerWeb::class, 'index'])->name('Oauth_clients_web_index');


    Route::get('Oauth_clients/show/{Oauth_clients}', [App\Http\Controllers\WEB\Oauth_clientsControllerWeb::class, 'index_one'])->name('Oauth_clients_web_index_one');


//Route::resource('Oauth_personal_access_clients',App\Http\Controllers\WEB\Oauth_personal_access_clientsControllerWeb::class);
    Route::get('Oauth_personal_access_clients', [App\Http\Controllers\WEB\Oauth_personal_access_clientsControllerWeb::class, 'index'])->name('Oauth_personal_access_clients_web_index');


    Route::get('Oauth_personal_access_clients/show/{Oauth_personal_access_clients}', [App\Http\Controllers\WEB\Oauth_personal_access_clientsControllerWeb::class, 'index_one'])->name('Oauth_personal_access_clients_web_index_one');


//Route::resource('Oauth_refresh_tokens',App\Http\Controllers\WEB\Oauth_refresh_tokensControllerWeb::class);
    Route::get('Oauth_refresh_tokens', [App\Http\Controllers\WEB\Oauth_refresh_tokensControllerWeb::class, 'index'])->name('Oauth_refresh_tokens_web_index');


    Route::get('Oauth_refresh_tokens/show/{Oauth_refresh_tokens}', [App\Http\Controllers\WEB\Oauth_refresh_tokensControllerWeb::class, 'index_one'])->name('Oauth_refresh_tokens_web_index_one');


//Route::resource('Objectifs',App\Http\Controllers\WEB\ObjectifsControllerWeb::class);
    Route::get('Objectifs', [App\Http\Controllers\WEB\ObjectifsControllerWeb::class, 'index'])->name('Objectifs_web_index');


    Route::get('Objectifs/show/{Objectifs}', [App\Http\Controllers\WEB\ObjectifsControllerWeb::class, 'index_one'])->name('Objectifs_web_index_one');


//Route::resource('Onlines',App\Http\Controllers\WEB\OnlinesControllerWeb::class);
    Route::get('Onlines', [App\Http\Controllers\WEB\OnlinesControllerWeb::class, 'index'])->name('Onlines_web_index');


    Route::get('Onlines/show/{Onlines}', [App\Http\Controllers\WEB\OnlinesControllerWeb::class, 'index_one'])->name('Onlines_web_index_one');


//Route::resource('Passagesrondes',App\Http\Controllers\WEB\PassagesrondesControllerWeb::class);
    Route::get('Passagesrondes', [App\Http\Controllers\WEB\PassagesrondesControllerWeb::class, 'index'])->name('Passagesrondes_web_index');


    Route::get('Passagesrondes/show/{Passagesrondes}', [App\Http\Controllers\WEB\PassagesrondesControllerWeb::class, 'index_one'])->name('Passagesrondes_web_index_one');


//Route::resource('Pastilles',App\Http\Controllers\WEB\PastillesControllerWeb::class);
    Route::get('Pastilles', [App\Http\Controllers\WEB\PastillesControllerWeb::class, 'index'])->name('Pastilles_web_index');


    Route::get('Pastilles/show/{Pastilles}', [App\Http\Controllers\WEB\PastillesControllerWeb::class, 'index_one'])->name('Pastilles_web_index_one');


//Route::resource('Permissions',App\Http\Controllers\WEB\PermissionsControllerWeb::class);
    Route::get('Permissions', [App\Http\Controllers\WEB\PermissionsControllerWeb::class, 'index'])->name('Permissions_web_index');


    Route::get('Permissions/show/{Permissions}', [App\Http\Controllers\WEB\PermissionsControllerWeb::class, 'index_one'])->name('Permissions_web_index_one');


//Route::resource('Permissionsdetails',App\Http\Controllers\WEB\PermissionsdetailsControllerWeb::class);
    Route::get('Permissionsdetails', [App\Http\Controllers\WEB\PermissionsdetailsControllerWeb::class, 'index'])->name('Permissionsdetails_web_index');


    Route::get('Permissionsdetails/show/{Permissionsdetails}', [App\Http\Controllers\WEB\PermissionsdetailsControllerWeb::class, 'index_one'])->name('Permissionsdetails_web_index_one');


//Route::resource('Perms',App\Http\Controllers\WEB\PermsControllerWeb::class);
    Route::get('Perms', [App\Http\Controllers\WEB\PermsControllerWeb::class, 'index'])->name('Perms_web_index');


    Route::get('Perms/show/{Perms}', [App\Http\Controllers\WEB\PermsControllerWeb::class, 'index_one'])->name('Perms_web_index_one');


//Route::resource('Pointages',App\Http\Controllers\WEB\PointagesControllerWeb::class);
    Route::get('Pointages', [App\Http\Controllers\WEB\PointagesControllerWeb::class, 'index'])->name('Pointages_web_index');


    Route::get('Pointages/show/{Pointages}', [App\Http\Controllers\WEB\PointagesControllerWeb::class, 'index_one'])->name('Pointages_web_index_one');


//Route::resource('Pointeuses',App\Http\Controllers\WEB\PointeusesControllerWeb::class);
    Route::get('Pointeuses', [App\Http\Controllers\WEB\PointeusesControllerWeb::class, 'index'])->name('Pointeuses_web_index');


    Route::get('Pointeuses/show/{Pointeuses}', [App\Http\Controllers\WEB\PointeusesControllerWeb::class, 'index_one'])->name('Pointeuses_web_index_one');


//Route::resource('Pointeusestransactions',App\Http\Controllers\WEB\PointeusestransactionsControllerWeb::class);
    Route::get('Pointeusestransactions', [App\Http\Controllers\WEB\PointeusestransactionsControllerWeb::class, 'index'])->name('Pointeusestransactions_web_index');


    Route::get('Pointeusestransactions/show/{Pointeusestransactions}', [App\Http\Controllers\WEB\PointeusestransactionsControllerWeb::class, 'index_one'])->name('Pointeusestransactions_web_index_one');


//Route::resource('Points',App\Http\Controllers\WEB\PointsControllerWeb::class);
    Route::get('Points', [App\Http\Controllers\WEB\PointsControllerWeb::class, 'index'])->name('Points_web_index');


    Route::get('Points/show/{Points}', [App\Http\Controllers\WEB\PointsControllerWeb::class, 'index_one'])->name('Points_web_index_one');


//Route::resource('Positions',App\Http\Controllers\WEB\PositionsControllerWeb::class);
    Route::get('Positions', [App\Http\Controllers\WEB\PositionsControllerWeb::class, 'index'])->name('Positions_web_index');


    Route::get('Positions/show/{Positions}', [App\Http\Controllers\WEB\PositionsControllerWeb::class, 'index_one'])->name('Positions_web_index_one');


//Route::resource('Postes',App\Http\Controllers\WEB\PostesControllerWeb::class);
    Route::get('Postes', [App\Http\Controllers\WEB\PostesControllerWeb::class, 'index'])->name('Postes_web_index');


    Route::get('Postes/show/{Postes}', [App\Http\Controllers\WEB\PostesControllerWeb::class, 'index_one'])->name('Postes_web_index_one');


//Route::resource('Postesagents',App\Http\Controllers\WEB\PostesagentsControllerWeb::class);
    Route::get('Postesagents', [App\Http\Controllers\WEB\PostesagentsControllerWeb::class, 'index'])->name('Postesagents_web_index');


    Route::get('Postesagents/show/{Postesagents}', [App\Http\Controllers\WEB\PostesagentsControllerWeb::class, 'index_one'])->name('Postesagents_web_index_one');


//Route::resource('Postesglobals',App\Http\Controllers\WEB\PostesglobalsControllerWeb::class);
    Route::get('Postesglobals', [App\Http\Controllers\WEB\PostesglobalsControllerWeb::class, 'index'])->name('Postesglobals_web_index');


    Route::get('Postesglobals/show/{Postesglobals}', [App\Http\Controllers\WEB\PostesglobalsControllerWeb::class, 'index_one'])->name('Postesglobals_web_index_one');


//Route::resource('Postesglobals_1',App\Http\Controllers\WEB\Postesglobals_1ControllerWeb::class);
    Route::get('Postesglobals_1', [App\Http\Controllers\WEB\Postesglobals_1ControllerWeb::class, 'index'])->name('Postesglobals_1_web_index');


    Route::get('Postesglobals_1/show/{Postesglobals_1}', [App\Http\Controllers\WEB\Postesglobals_1ControllerWeb::class, 'index_one'])->name('Postesglobals_1_web_index_one');


//Route::resource('Postespointeuses',App\Http\Controllers\WEB\PostespointeusesControllerWeb::class);
    Route::get('Postespointeuses', [App\Http\Controllers\WEB\PostespointeusesControllerWeb::class, 'index'])->name('Postespointeuses_web_index');


    Route::get('Postespointeuses/show/{Postespointeuses}', [App\Http\Controllers\WEB\PostespointeusesControllerWeb::class, 'index_one'])->name('Postespointeuses_web_index_one');


//Route::resource('Presences',App\Http\Controllers\WEB\PresencesControllerWeb::class);
    Route::get('Presences', [App\Http\Controllers\WEB\PresencesControllerWeb::class, 'index'])->name('Presences_web_index');


    Route::get('Presences/show/{Presences}', [App\Http\Controllers\WEB\PresencesControllerWeb::class, 'index_one'])->name('Presences_web_index_one');


//Route::resource('Prestations',App\Http\Controllers\WEB\PrestationsControllerWeb::class);
    Route::get('Prestations', [App\Http\Controllers\WEB\PrestationsControllerWeb::class, 'index'])->name('Prestations_web_index');


    Route::get('Prestations/show/{Prestations}', [App\Http\Controllers\WEB\PrestationsControllerWeb::class, 'index_one'])->name('Prestations_web_index_one');


//Route::resource('Preuves',App\Http\Controllers\WEB\PreuvesControllerWeb::class);
    Route::get('Preuves', [App\Http\Controllers\WEB\PreuvesControllerWeb::class, 'index'])->name('Preuves_web_index');


    Route::get('Preuves/show/{Preuves}', [App\Http\Controllers\WEB\PreuvesControllerWeb::class, 'index_one'])->name('Preuves_web_index_one');


//Route::resource('Processus',App\Http\Controllers\WEB\ProcessusControllerWeb::class);
    Route::get('Processus', [App\Http\Controllers\WEB\ProcessusControllerWeb::class, 'index'])->name('Processus_web_index');


    Route::get('Processus/show/{Processus}', [App\Http\Controllers\WEB\ProcessusControllerWeb::class, 'index_one'])->name('Processus_web_index_one');


//Route::resource('Programmations',App\Http\Controllers\WEB\ProgrammationsControllerWeb::class);
    Route::get('Programmations', [App\Http\Controllers\WEB\ProgrammationsControllerWeb::class, 'index'])->name('Programmations_web_index');


    Route::get('Programmations/show/{Programmations}', [App\Http\Controllers\WEB\ProgrammationsControllerWeb::class, 'index_one'])->name('Programmations_web_index_one');


//Route::resource('Programmationsdetails',App\Http\Controllers\WEB\ProgrammationsdetailsControllerWeb::class);
    Route::get('Programmationsdetails', [App\Http\Controllers\WEB\ProgrammationsdetailsControllerWeb::class, 'index'])->name('Programmationsdetails_web_index');


    Route::get('Programmationsdetails/show/{Programmationsdetails}', [App\Http\Controllers\WEB\ProgrammationsdetailsControllerWeb::class, 'index_one'])->name('Programmationsdetails_web_index_one');


//Route::resource('Programmationsrondes',App\Http\Controllers\WEB\ProgrammationsrondesControllerWeb::class);
    Route::get('Programmationsrondes', [App\Http\Controllers\WEB\ProgrammationsrondesControllerWeb::class, 'index'])->name('Programmationsrondes_web_index');


    Route::get('Programmationsrondes/show/{Programmationsrondes}', [App\Http\Controllers\WEB\ProgrammationsrondesControllerWeb::class, 'index_one'])->name('Programmationsrondes_web_index_one');


//Route::resource('Programmationsusers',App\Http\Controllers\WEB\ProgrammationsusersControllerWeb::class);
    Route::get('Programmationsusers', [App\Http\Controllers\WEB\ProgrammationsusersControllerWeb::class, 'index'])->name('Programmationsusers_web_index');


    Route::get('Programmationsusers/show/{Programmationsusers}', [App\Http\Controllers\WEB\ProgrammationsusersControllerWeb::class, 'index_one'])->name('Programmationsusers_web_index_one');


//Route::resource('Programmes',App\Http\Controllers\WEB\ProgrammesControllerWeb::class);
    Route::get('Programmes', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index'])->name('Programmes_web_index');


    Route::get('Programmes/show/{Programmes}', [App\Http\Controllers\WEB\ProgrammesControllerWeb::class, 'index_one'])->name('Programmes_web_index_one');


//Route::resource('Programmesrondes',App\Http\Controllers\WEB\ProgrammesrondesControllerWeb::class);
    Route::get('Programmesrondes', [App\Http\Controllers\WEB\ProgrammesrondesControllerWeb::class, 'index'])->name('Programmesrondes_web_index');


    Route::get('Programmesrondes/show/{Programmesrondes}', [App\Http\Controllers\WEB\ProgrammesrondesControllerWeb::class, 'index_one'])->name('Programmesrondes_web_index_one');


//Route::resource('Projets',App\Http\Controllers\WEB\ProjetsControllerWeb::class);
    Route::get('Projets', [App\Http\Controllers\WEB\ProjetsControllerWeb::class, 'index'])->name('Projets_web_index');


    Route::get('Projets/show/{Projets}', [App\Http\Controllers\WEB\ProjetsControllerWeb::class, 'index_one'])->name('Projets_web_index_one');


//Route::resource('Provinces',App\Http\Controllers\WEB\ProvincesControllerWeb::class);
    Route::get('Provinces', [App\Http\Controllers\WEB\ProvincesControllerWeb::class, 'index'])->name('Provinces_web_index');


    Route::get('Provinces/show/{Provinces}', [App\Http\Controllers\WEB\ProvincesControllerWeb::class, 'index_one'])->name('Provinces_web_index_one');


//Route::resource('Rapportpostes',App\Http\Controllers\WEB\RapportpostesControllerWeb::class);
    Route::get('Rapportpostes', [App\Http\Controllers\WEB\RapportpostesControllerWeb::class, 'index'])->name('Rapportpostes_web_index');


    Route::get('Rapportpostes/show/{Rapportpostes}', [App\Http\Controllers\WEB\RapportpostesControllerWeb::class, 'index_one'])->name('Rapportpostes_web_index_one');


// //Route::resource('Rapports',App\Http\Controllers\WEB\RapportsControllerWeb::class);
//     Route::get('Rapports', [App\Http\Controllers\WEB\RapportsControllerWeb::class, 'index'])->name('Rapports_web_index');


//     Route::get('Rapports/show/{Rapports}', [App\Http\Controllers\WEB\RapportsControllerWeb::class, 'index_one'])->name('Rapports_web_index_one');


//Route::resource('Recuperes',App\Http\Controllers\WEB\RecuperesControllerWeb::class);
    Route::get('Recuperes', [App\Http\Controllers\WEB\RecuperesControllerWeb::class, 'index'])->name('Recuperes_web_index');


    Route::get('Recuperes/show/{Recuperes}', [App\Http\Controllers\WEB\RecuperesControllerWeb::class, 'index_one'])->name('Recuperes_web_index_one');


//Route::resource('Ressources',App\Http\Controllers\WEB\RessourcesControllerWeb::class);
    Route::get('Ressources', [App\Http\Controllers\WEB\RessourcesControllerWeb::class, 'index'])->name('Ressources_web_index');


    Route::get('Ressources/show/{Ressources}', [App\Http\Controllers\WEB\RessourcesControllerWeb::class, 'index_one'])->name('Ressources_web_index_one');


//Route::resource('Role_has_permission',App\Http\Controllers\WEB\Role_has_permissionControllerWeb::class);
    Route::get('Role_has_permission', [App\Http\Controllers\WEB\Role_has_permissionControllerWeb::class, 'index'])->name('Role_has_permission_web_index');


    Route::get('Role_has_permission/show/{Role_has_permission}', [App\Http\Controllers\WEB\Role_has_permissionControllerWeb::class, 'index_one'])->name('Role_has_permission_web_index_one');


//Route::resource('Role_has_permissions',App\Http\Controllers\WEB\Role_has_permissionsControllerWeb::class);
    Route::get('Role_has_permissions', [App\Http\Controllers\WEB\Role_has_permissionsControllerWeb::class, 'index'])->name('Role_has_permissions_web_index');


    Route::get('Role_has_permissions/show/{Role_has_permissions}', [App\Http\Controllers\WEB\Role_has_permissionsControllerWeb::class, 'index_one'])->name('Role_has_permissions_web_index_one');


//Route::resource('Roles',App\Http\Controllers\WEB\RolesControllerWeb::class);
    Route::get('Roles', [App\Http\Controllers\WEB\RolesControllerWeb::class, 'index'])->name('Roles_web_index');


    Route::get('Roles/show/{Roles}', [App\Http\Controllers\WEB\RolesControllerWeb::class, 'index_one'])->name('Roles_web_index_one');


//Route::resource('Services',App\Http\Controllers\WEB\ServicesControllerWeb::class);
    Route::get('Services', [App\Http\Controllers\WEB\ServicesControllerWeb::class, 'index'])->name('Services_web_index');


    Route::get('Services/show/{Services}', [App\Http\Controllers\WEB\ServicesControllerWeb::class, 'index_one'])->name('Services_web_index_one');


//Route::resource('Sexes',App\Http\Controllers\WEB\SexesControllerWeb::class);
    Route::get('Sexes', [App\Http\Controllers\WEB\SexesControllerWeb::class, 'index'])->name('Sexes_web_index');


    Route::get('Sexes/show/{Sexes}', [App\Http\Controllers\WEB\SexesControllerWeb::class, 'index_one'])->name('Sexes_web_index_one');


//Route::resource('Sites',App\Http\Controllers\WEB\SitesControllerWeb::class);
    Route::get('Sites', [App\Http\Controllers\WEB\SitesControllerWeb::class, 'index'])->name('Sites_web_index');


    Route::get('Sites/show/{Sites}', [App\Http\Controllers\WEB\SitesControllerWeb::class, 'index_one'])->name('Sites_web_index_one');


//Route::resource('Sitesglobals',App\Http\Controllers\WEB\SitesglobalsControllerWeb::class);
    Route::get('Sitesglobals', [App\Http\Controllers\WEB\SitesglobalsControllerWeb::class, 'index'])->name('Sitesglobals_web_index');


    Route::get('Sitesglobals/show/{Sitesglobals}', [App\Http\Controllers\WEB\SitesglobalsControllerWeb::class, 'index_one'])->name('Sitesglobals_web_index_one');


//Route::resource('Sitespointeuses',App\Http\Controllers\WEB\SitespointeusesControllerWeb::class);
    Route::get('Sitespointeuses', [App\Http\Controllers\WEB\SitespointeusesControllerWeb::class, 'index'])->name('Sitespointeuses_web_index');


    Route::get('Sitespointeuses/show/{Sitespointeuses}', [App\Http\Controllers\WEB\SitespointeusesControllerWeb::class, 'index_one'])->name('Sitespointeuses_web_index_one');


//Route::resource('Sitessdeplacements',App\Http\Controllers\WEB\SitessdeplacementsControllerWeb::class);
    Route::get('Sitessdeplacements', [App\Http\Controllers\WEB\SitessdeplacementsControllerWeb::class, 'index'])->name('Sitessdeplacements_web_index');


    Route::get('Sitessdeplacements/show/{Sitessdeplacements}', [App\Http\Controllers\WEB\SitessdeplacementsControllerWeb::class, 'index_one'])->name('Sitessdeplacements_web_index_one');


//Route::resource('Situations',App\Http\Controllers\WEB\SituationsControllerWeb::class);
    Route::get('Situations', [App\Http\Controllers\WEB\SituationsControllerWeb::class, 'index'])->name('Situations_web_index');


    Route::get('Situations/show/{Situations}', [App\Http\Controllers\WEB\SituationsControllerWeb::class, 'index_one'])->name('Situations_web_index_one');


//Route::resource('Soldables',App\Http\Controllers\WEB\SoldablesControllerWeb::class);
    Route::get('Soldables', [App\Http\Controllers\WEB\SoldablesControllerWeb::class, 'index'])->name('Soldables_web_index');


    Route::get('Soldables/show/{Soldables}', [App\Http\Controllers\WEB\SoldablesControllerWeb::class, 'index_one'])->name('Soldables_web_index_one');


//Route::resource('Statszones',App\Http\Controllers\WEB\StatszonesControllerWeb::class);
    Route::get('Statszones', [App\Http\Controllers\WEB\StatszonesControllerWeb::class, 'index'])->name('Statszones_web_index');


    Route::get('Statszones/show/{Statszones}', [App\Http\Controllers\WEB\StatszonesControllerWeb::class, 'index_one'])->name('Statszones_web_index_one');


//Route::resource('Supervirzclients',App\Http\Controllers\WEB\SupervirzclientsControllerWeb::class);
    Route::get('Supervirzclients', [App\Http\Controllers\WEB\SupervirzclientsControllerWeb::class, 'index'])->name('Supervirzclients_web_index');


    Route::get('Supervirzclients/show/{Supervirzclients}', [App\Http\Controllers\WEB\SupervirzclientsControllerWeb::class, 'index_one'])->name('Supervirzclients_web_index_one');


//Route::resource('Supervirzclientshides',App\Http\Controllers\WEB\SupervirzclientshidesControllerWeb::class);
    Route::get('Supervirzclientshides', [App\Http\Controllers\WEB\SupervirzclientshidesControllerWeb::class, 'index'])->name('Supervirzclientshides_web_index');


    Route::get('Supervirzclientshides/show/{Supervirzclientshides}', [App\Http\Controllers\WEB\SupervirzclientshidesControllerWeb::class, 'index_one'])->name('Supervirzclientshides_web_index_one');


//Route::resource('Surveillances',App\Http\Controllers\WEB\SurveillancesControllerWeb::class);
    Route::get('Surveillances', [App\Http\Controllers\WEB\SurveillancesControllerWeb::class, 'index'])->name('Surveillances_web_index');


    Route::get('Surveillances/show/{Surveillances}', [App\Http\Controllers\WEB\SurveillancesControllerWeb::class, 'index_one'])->name('Surveillances_web_index_one');


//Route::resource('Switchsusers',App\Http\Controllers\WEB\SwitchsusersControllerWeb::class);
    Route::get('Switchsusers', [App\Http\Controllers\WEB\SwitchsusersControllerWeb::class, 'index'])->name('Switchsusers_web_index');


    Route::get('Switchsusers/show/{Switchsusers}', [App\Http\Controllers\WEB\SwitchsusersControllerWeb::class, 'index_one'])->name('Switchsusers_web_index_one');


//Route::resource('Taches',App\Http\Controllers\WEB\TachesControllerWeb::class);
    Route::get('Taches', [App\Http\Controllers\WEB\TachesControllerWeb::class, 'index'])->name('Taches_web_index');


    Route::get('Taches/show/{Taches}', [App\Http\Controllers\WEB\TachesControllerWeb::class, 'index_one'])->name('Taches_web_index_one');


//Route::resource('Tachespointeuses',App\Http\Controllers\WEB\TachespointeusesControllerWeb::class);
    Route::get('Tachespointeuses', [App\Http\Controllers\WEB\TachespointeusesControllerWeb::class, 'index'])->name('Tachespointeuses_web_index');


    Route::get('Tachespointeuses/show/{Tachespointeuses}', [App\Http\Controllers\WEB\TachespointeusesControllerWeb::class, 'index_one'])->name('Tachespointeuses_web_index_one');


//Route::resource('Terminals',App\Http\Controllers\WEB\TerminalsControllerWeb::class);
    Route::get('Terminals', [App\Http\Controllers\WEB\TerminalsControllerWeb::class, 'index'])->name('Terminals_web_index');


    Route::get('Terminals/show/{Terminals}', [App\Http\Controllers\WEB\TerminalsControllerWeb::class, 'index_one'])->name('Terminals_web_index_one');


//Route::resource('Trackings',App\Http\Controllers\WEB\TrackingsControllerWeb::class);
    Route::get('Trackings', [App\Http\Controllers\WEB\TrackingsControllerWeb::class, 'index'])->name('Trackings_web_index');


    Route::get('Trackings/show/{Trackings}', [App\Http\Controllers\WEB\TrackingsControllerWeb::class, 'index_one'])->name('Trackings_web_index_one');


//Route::resource('Trajets',App\Http\Controllers\WEB\TrajetsControllerWeb::class);
    Route::get('Trajets', [App\Http\Controllers\WEB\TrajetsControllerWeb::class, 'index'])->name('Trajets_web_index');


    Route::get('Trajets/show/{Trajets}', [App\Http\Controllers\WEB\TrajetsControllerWeb::class, 'index_one'])->name('Trajets_web_index_one');


//Route::resource('Transactionhistoriques',App\Http\Controllers\WEB\TransactionhistoriquesControllerWeb::class);
    Route::get('Transactionhistoriques', [App\Http\Controllers\WEB\TransactionhistoriquesControllerWeb::class, 'index'])->name('Transactionhistoriques_web_index');


    Route::get('Transactionhistoriques/show/{Transactionhistoriques}', [App\Http\Controllers\WEB\TransactionhistoriquesControllerWeb::class, 'index_one'])->name('Transactionhistoriques_web_index_one');


//Route::resource('Transactions',App\Http\Controllers\WEB\TransactionsControllerWeb::class);
    Route::get('Transactions', [App\Http\Controllers\WEB\TransactionsControllerWeb::class, 'index'])->name('Transactions_web_index');


    Route::get('Transactions/show/{Transactions}', [App\Http\Controllers\WEB\TransactionsControllerWeb::class, 'index_one'])->name('Transactions_web_index_one');


//Route::resource('Transactionsdetails',App\Http\Controllers\WEB\TransactionsdetailsControllerWeb::class);
    Route::get('Transactionsdetails', [App\Http\Controllers\WEB\TransactionsdetailsControllerWeb::class, 'index'])->name('Transactionsdetails_web_index');


    Route::get('Transactionsdetails/show/{Transactionsdetails}', [App\Http\Controllers\WEB\TransactionsdetailsControllerWeb::class, 'index_one'])->name('Transactionsdetails_web_index_one');


//Route::resource('Transactionsulterieurs',App\Http\Controllers\WEB\TransactionsulterieursControllerWeb::class);
    Route::get('Transactionsulterieurs', [App\Http\Controllers\WEB\TransactionsulterieursControllerWeb::class, 'index'])->name('Transactionsulterieurs_web_index');


    Route::get('Transactionsulterieurs/show/{Transactionsulterieurs}', [App\Http\Controllers\WEB\TransactionsulterieursControllerWeb::class, 'index_one'])->name('Transactionsulterieurs_web_index_one');


//Route::resource('Transporteurs',App\Http\Controllers\WEB\TransporteursControllerWeb::class);
    Route::get('Transporteurs', [App\Http\Controllers\WEB\TransporteursControllerWeb::class, 'index'])->name('Transporteurs_web_index');


    Route::get('Transporteurs/show/{Transporteurs}', [App\Http\Controllers\WEB\TransporteursControllerWeb::class, 'index_one'])->name('Transporteurs_web_index_one');


//Route::resource('Transporteurstrajets',App\Http\Controllers\WEB\TransporteurstrajetsControllerWeb::class);
    Route::get('Transporteurstrajets', [App\Http\Controllers\WEB\TransporteurstrajetsControllerWeb::class, 'index'])->name('Transporteurstrajets_web_index');


    Route::get('Transporteurstrajets/show/{Transporteurstrajets}', [App\Http\Controllers\WEB\TransporteurstrajetsControllerWeb::class, 'index_one'])->name('Transporteurstrajets_web_index_one');


//Route::resource('Travailleurs',App\Http\Controllers\WEB\TravailleursControllerWeb::class);
    Route::get('Travailleurs', [App\Http\Controllers\WEB\TravailleursControllerWeb::class, 'index'])->name('Travailleurs_web_index');


    Route::get('Travailleurs/show/{Travailleurs}', [App\Http\Controllers\WEB\TravailleursControllerWeb::class, 'index_one'])->name('Travailleurs_web_index_one');


//Route::resource('Typeinterventions',App\Http\Controllers\WEB\TypeinterventionsControllerWeb::class);
    Route::get('Typeinterventions', [App\Http\Controllers\WEB\TypeinterventionsControllerWeb::class, 'index'])->name('Typeinterventions_web_index');


    Route::get('Typeinterventions/show/{Typeinterventions}', [App\Http\Controllers\WEB\TypeinterventionsControllerWeb::class, 'index_one'])->name('Typeinterventions_web_index_one');


//Route::resource('Types',App\Http\Controllers\WEB\TypesControllerWeb::class);
    Route::get('Types', [App\Http\Controllers\WEB\TypesControllerWeb::class, 'index'])->name('Types_web_index');


    Route::get('Types/show/{Types}', [App\Http\Controllers\WEB\TypesControllerWeb::class, 'index_one'])->name('Types_web_index_one');


//Route::resource('Typesabscences',App\Http\Controllers\WEB\TypesabscencesControllerWeb::class);
    Route::get('Typesabscences', [App\Http\Controllers\WEB\TypesabscencesControllerWeb::class, 'index'])->name('Typesabscences_web_index');


    Route::get('Typesabscences/show/{Typesabscences}', [App\Http\Controllers\WEB\TypesabscencesControllerWeb::class, 'index_one'])->name('Typesabscences_web_index_one');


//Route::resource('Typesagentshoraires',App\Http\Controllers\WEB\TypesagentshorairesControllerWeb::class);
    Route::get('Typesagentshoraires', [App\Http\Controllers\WEB\TypesagentshorairesControllerWeb::class, 'index'])->name('Typesagentshoraires_web_index');


    Route::get('Typesagentshoraires/show/{Typesagentshoraires}', [App\Http\Controllers\WEB\TypesagentshorairesControllerWeb::class, 'index_one'])->name('Typesagentshoraires_web_index_one');


//Route::resource('Typeseffectifs',App\Http\Controllers\WEB\TypeseffectifsControllerWeb::class);
    Route::get('Typeseffectifs', [App\Http\Controllers\WEB\TypeseffectifsControllerWeb::class, 'index'])->name('Typeseffectifs_web_index');


    Route::get('Typeseffectifs/show/{Typeseffectifs}', [App\Http\Controllers\WEB\TypeseffectifsControllerWeb::class, 'index_one'])->name('Typeseffectifs_web_index_one');


//Route::resource('Typesheures',App\Http\Controllers\WEB\TypesheuresControllerWeb::class);
    Route::get('Typesheures', [App\Http\Controllers\WEB\TypesheuresControllerWeb::class, 'index'])->name('Typesheures_web_index');


    Route::get('Typesheures/show/{Typesheures}', [App\Http\Controllers\WEB\TypesheuresControllerWeb::class, 'index_one'])->name('Typesheures_web_index_one');


//Route::resource('Typesmoyenstransports',App\Http\Controllers\WEB\TypesmoyenstransportsControllerWeb::class);
    Route::get('Typesmoyenstransports', [App\Http\Controllers\WEB\TypesmoyenstransportsControllerWeb::class, 'index'])->name('Typesmoyenstransports_web_index');


    Route::get('Typesmoyenstransports/show/{Typesmoyenstransports}', [App\Http\Controllers\WEB\TypesmoyenstransportsControllerWeb::class, 'index_one'])->name('Typesmoyenstransports_web_index_one');


//Route::resource('Typespostes',App\Http\Controllers\WEB\TypespostesControllerWeb::class);
    Route::get('Typespostes', [App\Http\Controllers\WEB\TypespostesControllerWeb::class, 'index'])->name('Typespostes_web_index');


    Route::get('Typespostes/show/{Typespostes}', [App\Http\Controllers\WEB\TypespostesControllerWeb::class, 'index_one'])->name('Typespostes_web_index_one');


//Route::resource('Typessites',App\Http\Controllers\WEB\TypessitesControllerWeb::class);
    Route::get('Typessites', [App\Http\Controllers\WEB\TypessitesControllerWeb::class, 'index'])->name('Typessites_web_index');


    Route::get('Typessites/show/{Typessites}', [App\Http\Controllers\WEB\TypessitesControllerWeb::class, 'index_one'])->name('Typessites_web_index_one');


//Route::resource('Typestaches',App\Http\Controllers\WEB\TypestachesControllerWeb::class);
    Route::get('Typestaches', [App\Http\Controllers\WEB\TypestachesControllerWeb::class, 'index'])->name('Typestaches_web_index');


    Route::get('Typestaches/show/{Typestaches}', [App\Http\Controllers\WEB\TypestachesControllerWeb::class, 'index_one'])->name('Typestaches_web_index_one');


//Route::resource('Userbadges',App\Http\Controllers\WEB\UserbadgesControllerWeb::class);
    Route::get('Userbadges', [App\Http\Controllers\WEB\UserbadgesControllerWeb::class, 'index'])->name('Userbadges_web_index');


    Route::get('Userbadges/show/{Userbadges}', [App\Http\Controllers\WEB\UserbadgesControllerWeb::class, 'index_one'])->name('Userbadges_web_index_one');


//Route::resource('Users',App\Http\Controllers\WEB\UsersControllerWeb::class);
    Route::get('Users', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index'])->name('Users_web_index');


    Route::get('Users/show/{Users}', [App\Http\Controllers\WEB\UsersControllerWeb::class, 'index_one'])->name('Users_web_index_one');


//Route::resource('Usersgraphiques',App\Http\Controllers\WEB\UsersgraphiquesControllerWeb::class);
    Route::get('Usersgraphiques', [App\Http\Controllers\WEB\UsersgraphiquesControllerWeb::class, 'index'])->name('Usersgraphiques_web_index');


    Route::get('Usersgraphiques/show/{Usersgraphiques}', [App\Http\Controllers\WEB\UsersgraphiquesControllerWeb::class, 'index_one'])->name('Usersgraphiques_web_index_one');


//Route::resource('Userstypespostes',App\Http\Controllers\WEB\UserstypespostesControllerWeb::class);
    Route::get('Userstypespostes', [App\Http\Controllers\WEB\UserstypespostesControllerWeb::class, 'index'])->name('Userstypespostes_web_index');


    Route::get('Userstypespostes/show/{Userstypespostes}', [App\Http\Controllers\WEB\UserstypespostesControllerWeb::class, 'index_one'])->name('Userstypespostes_web_index_one');


//Route::resource('Userszones',App\Http\Controllers\WEB\UserszonesControllerWeb::class);
    Route::get('Userszones', [App\Http\Controllers\WEB\UserszonesControllerWeb::class, 'index'])->name('Userszones_web_index');


    Route::get('Userszones/show/{Userszones}', [App\Http\Controllers\WEB\UserszonesControllerWeb::class, 'index_one'])->name('Userszones_web_index_one');


//Route::resource('Vacationspostes',App\Http\Controllers\WEB\VacationspostesControllerWeb::class);
    Route::get('Vacationspostes', [App\Http\Controllers\WEB\VacationspostesControllerWeb::class, 'index'])->name('Vacationspostes_web_index');


    Route::get('Vacationspostes/show/{Vacationspostes}', [App\Http\Controllers\WEB\VacationspostesControllerWeb::class, 'index_one'])->name('Vacationspostes_web_index_one');


//Route::resource('Validations',App\Http\Controllers\WEB\ValidationsControllerWeb::class);
    Route::get('Validations', [App\Http\Controllers\WEB\ValidationsControllerWeb::class, 'index'])->name('Validations_web_index');


    Route::get('Validations/show/{Validations}', [App\Http\Controllers\WEB\ValidationsControllerWeb::class, 'index_one'])->name('Validations_web_index_one');


//Route::resource('Variables',App\Http\Controllers\WEB\VariablesControllerWeb::class);
    Route::get('Variables', [App\Http\Controllers\WEB\VariablesControllerWeb::class, 'index'])->name('Variables_web_index');


    Route::get('Variables/show/{Variables}', [App\Http\Controllers\WEB\VariablesControllerWeb::class, 'index_one'])->name('Variables_web_index_one');


//Route::resource('Vehicules',App\Http\Controllers\WEB\VehiculesControllerWeb::class);
    Route::get('Vehicules', [App\Http\Controllers\WEB\VehiculesControllerWeb::class, 'index'])->name('Vehicules_web_index');


    Route::get('Vehicules/show/{Vehicules}', [App\Http\Controllers\WEB\VehiculesControllerWeb::class, 'index_one'])->name('Vehicules_web_index_one');


//Route::resource('Ventilations',App\Http\Controllers\WEB\VentilationsControllerWeb::class);
    Route::get('Ventilations', [App\Http\Controllers\WEB\VentilationsControllerWeb::class, 'index'])->name('Ventilations_web_index');


    Route::get('Ventilations/show/{Ventilations}', [App\Http\Controllers\WEB\VentilationsControllerWeb::class, 'index_one'])->name('Ventilations_web_index_one');


//Route::resource('Villes',App\Http\Controllers\WEB\VillesControllerWeb::class);
    Route::get('Villes', [App\Http\Controllers\WEB\VillesControllerWeb::class, 'index'])->name('Villes_web_index');


    Route::get('Villes/show/{Villes}', [App\Http\Controllers\WEB\VillesControllerWeb::class, 'index_one'])->name('Villes_web_index_one');


//Route::resource('Voitures',App\Http\Controllers\WEB\VoituresControllerWeb::class);
    Route::get('Voitures', [App\Http\Controllers\WEB\VoituresControllerWeb::class, 'index'])->name('Voitures_web_index');


    Route::get('Voitures/show/{Voitures}', [App\Http\Controllers\WEB\VoituresControllerWeb::class, 'index_one'])->name('Voitures_web_index_one');


//Route::resource('Websockets_statistics_entries',App\Http\Controllers\WEB\Websockets_statistics_entriesControllerWeb::class);
    Route::get('Websockets_statistics_entries', [App\Http\Controllers\WEB\Websockets_statistics_entriesControllerWeb::class, 'index'])->name('Websockets_statistics_entries_web_index');


    Route::get('Websockets_statistics_entries/show/{Websockets_statistics_entries}', [App\Http\Controllers\WEB\Websockets_statistics_entriesControllerWeb::class, 'index_one'])->name('Websockets_statistics_entries_web_index_one');


//Route::resource('Works',App\Http\Controllers\WEB\WorksControllerWeb::class);
    Route::get('Works', [App\Http\Controllers\WEB\WorksControllerWeb::class, 'index'])->name('Works_web_index');


    Route::get('Works/show/{Works}', [App\Http\Controllers\WEB\WorksControllerWeb::class, 'index_one'])->name('Works_web_index_one');


//Route::resource('Zones',App\Http\Controllers\WEB\ZonesControllerWeb::class);
    Route::get('Zones', [App\Http\Controllers\WEB\ZonesControllerWeb::class, 'index'])->name('Zones_web_index');


    Route::get('Zones/show/{Zones}', [App\Http\Controllers\WEB\ZonesControllerWeb::class, 'index_one'])->name('Zones_web_index_one');


});
