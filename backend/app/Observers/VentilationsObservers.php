<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\ValidationsModel;
use App\Models\prod\Ventilation;
use App\Validations\VentilationsValidation;
use Illuminate\Support\Facades\Auth;


class VentilationsObservers
{
    /**
     * Handle the Ventilations "created" event.
     *
     * @param Ventilation $ventilation
     * @return void
     */
    public static function created(Ventilation $ventilation)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Ventilation';
        $crud->model_id = is_array($ventilation->id) ? $ventilation->id[0] : $ventilation->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $ventilation->toJson();
        $crud->data_end = json_encode($ventilation->getAttributes());
        $crud->save();


        $ventilation->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'ventilations'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $ventilation->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\VentilationsValidation')) {

            VentilationsValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\VentilationsValidation')) {
            VentilationsValidation::after($pipeline);

        }


    }

    /**
     * Handle the Ventilations "updated" event.
     *
     * @param Ventilation $ventilation
     * @return void
     */
    public static function updated(Ventilation $ventilation)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Ventilation';
        $crud->model_id = is_array($ventilation->id) ? $ventilation->id[0] : $ventilation->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $ventilation->toJson();
        $crud->data_end = json_encode($ventilation->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Ventilations "deleted" event.
     *
     * @param Ventilation $ventilation
     * @return void
     */
    public static function deleted(Ventilation $ventilation)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Ventilation';
        $crud->model_id = is_array($ventilation->id) ? $ventilation->id[0] : $ventilation->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $ventilation->toJson();
        $crud->data_end = json_encode($ventilation->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Ventilations "restored" event.
     *
     * @param Ventilation $ventilation
     * @return void
     */
    public static function restored(Ventilation $ventilation)
    {
//
    }

    /**
     * Handle the Ventilations "force deleted" event.
     *
     * @param Ventilation $ventilation
     * @return void
     */
    public static function forceDeleted(Ventilation $ventilation)
    {
//


    }
}
