<?php

namespace App\Observers;

use App\Models\prod\Calendrier;
use App\Models\prod\CrudsModel;
use App\Models\prod\ValidationsModel;
use App\Validations\CalendriersValidation;
use Illuminate\Support\Facades\Auth;


class CalendriersObservers
{
    /**
     * Handle the Calendriers "created" event.
     *
     * @param Calendrier $calendrier
     * @return void
     */
    public static function created(Calendrier $calendrier)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Calendrier';
        $crud->model_id = is_array($calendrier->id) ? $calendrier->id[0] : $calendrier->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $calendrier->toJson();
        $crud->data_end = json_encode($calendrier->getAttributes());
        $crud->save();


        $calendrier->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'calendriers'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $calendrier->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\CalendriersValidation')) {

            CalendriersValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\CalendriersValidation')) {
            CalendriersValidation::after($pipeline);

        }


    }

    /**
     * Handle the Calendriers "updated" event.
     *
     * @param Calendrier $calendrier
     * @return void
     */
    public static function updated(Calendrier $calendrier)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Calendrier';
        $crud->model_id = is_array($calendrier->id) ? $calendrier->id[0] : $calendrier->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $calendrier->toJson();
        $crud->data_end = json_encode($calendrier->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Calendriers "deleted" event.
     *
     * @param Calendrier $calendrier
     * @return void
     */
    public static function deleted(Calendrier $calendrier)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Calendrier';
        $crud->model_id = is_array($calendrier->id) ? $calendrier->id[0] : $calendrier->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $calendrier->toJson();
        $crud->data_end = json_encode($calendrier->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Calendriers "restored" event.
     *
     * @param Calendrier $calendrier
     * @return void
     */
    public static function restored(Calendrier $calendrier)
    {
//
    }

    /**
     * Handle the Calendriers "force deleted" event.
     *
     * @param Calendrier $calendrier
     * @return void
     */
    public static function forceDeleted(Calendrier $calendrier)
    {
//


    }
}
