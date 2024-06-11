<?php

namespace App\Console;

use App\Http\Pointages;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
        //        $schedule->call(function () {
        //            dispatch((new archiverLesAnciensPointagesJobs()))->onQueue('collect');
        //        })
        //            ->everySixHours()
        //            ->name('Archiver tous les anciens pointages');

        //--------1 er etape Fin  -----------


        //--------2 er etape Debut  Nettoyage-----------
        //        $schedule->call(function () {
        //            dispatch((new corrigeUsersBadgeJobs()))->onQueue('nettoyage');
        //        })
        //            ->everyTwoMinutes()
        ////            ->everyMinute()
        //            ->name('Suppression des zero avant le badge de lagents');
        //
        //        $schedule->call(function () {
        //            dispatch((new corrigeTelericPointagesBadgeJobs()))->onQueue('nettoyage');
        //        })
        //            ->everyTwoMinutes()
        //            ->name('Coorection des numero de badge collecter sur teleric');

        $schedule->call(function () {
            Pointages::genereListing();
        })
            ->daily()->at('05:00')
            ->name('Generer des listings journaliers par zone');

        //--------2 er etape Fin   -----------


        //--------3 er etape Debut  Pre-traitement-----------

        //        $schedule->call(function () {
        ////            Optimizer
        //            dispatch((new updatePastilleNameJobs()))->onQueue('pretraitement');
        //        })
        //            ->everyTwoMinutes()
        //            ->name('Associer le nom de tache a la pastille');
        //
        //
        //        $schedule->call(function () {
        //            dispatch((new synchroniseAllTachesForTransactionJobs()))->onQueue('pretraitement');
        //        })
        //            ->everyThirtyMinutes()
        //            ->name('Associer les pointage a leur tache eventuelle');
        //
        //        $schedule->call(function () {
        //
        //            dispatch((new synchroniseAllPostesForTransactionJobs()))->onQueue('pretraitement');
        //        })
        //            ->everyThirtyMinutes()
        ////            ->everyMinute()
        //            ->name('Associer les pointage a leur poste eventuelle');
        //

        //--------3 er etape Fin  -----------


        //--------4 er etape Debut  analyse -----------

        //
        //        $schedule->call(function () {
        //            Utils::runImportations();
        //        })
        //            ->everyTwoMinutes()
        //            ->name('Importer les donnees excel');

        //--------4 er etape Fin  -----------
        //        $schedule->call(function () {
        //
        //            dispatch((new VacationAgentsJobs()))->onQueue('analyse');
        //        })
        //            ->everyTwoMinutes()
        //            ->name('generer les vacations par agents');


        $schedule
            ->command('backup:run')->daily()->at('01:00')
            ->onFailure(function () {
            })
            ->onSuccess(function () {
            })
            ->name('Sauvegarde des donnees');


//        $schedule->call(function () {
//            Pointages::findBestPointages1();
//        })
//            ->everyFiveMinutes()
//            ->name('Trouver le bon pointages pour le programme');

        $schedule->call(function () {
            Pointages::importAgents();
        })
            ->everyMinute()
            ->name('Importer les agents muti-domaines');

        $schedule->call(function () {
            Pointages::getRondiersPastilles();
        })
            ->everyTwoHours()
            ->name('Importer les pastilles de rondes ');

        $schedule->call(function () {
            Pointages::generateTraitements();
        })
            ->everyTwoMinutes()
            ->name('Generation des traitements de transurb ');

        $schedule->call(function () {
            Pointages::importPostes();
        })
            ->everyMinute()
            ->name('Importer les postes muti-domaines');

        $schedule->call(function () {
            Pointages::remplirPosition();
        })
            ->everyMinute()
            ->name('Collecter les positions des balises');

        $schedule->call(function () {
            Pointages::importPointages();
        })
            ->everyMinute()
            ->name('Importation des pointages');

        $schedule->call(function () {
            Pointages::rapportPostePointage();
        })
            ->dailyAt('09:00')
            ->name('Remplir Pointages par postes.');

        $schedule->call(function () {
            Pointages::rapportPostePointage();
        })
            ->dailyAt('23:59')
            ->name('Remplir Pointages par postes.');


        $schedule->call(function () {
            Pointages::rapportPosteVacation();
        })
            ->dailyAt('06:00')
            ->name('Remplir Vacation par postes.');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
