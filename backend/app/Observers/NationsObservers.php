<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\Nation;
use App\Models\prod\ValidationsModel;
use App\Validations\NationsValidation;
use Illuminate\Support\Facades\Auth;


class NationsObservers
{
    /**
     * Handle the Nations "created" event.
     *
     * @param Nation $nation
     * @return void
     */
    public static function created(Nation $nation)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Nation';
        $crud->model_id = is_array($nation->id) ? $nation->id[0] : $nation->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $nation->toJson();
        $crud->data_end = json_encode($nation->getAttributes());
        $crud->save();


        $nation->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'nations'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $nation->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\NationsValidation')) {

            NationsValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\NationsValidation')) {
            NationsValidation::after($pipeline);

        }


    }

    /**
     * Handle the Nations "updated" event.
     *
     * @param Nation $nation
     * @return void
     */
    public static function updated(Nation $nation)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Nation';
        $crud->model_id = is_array($nation->id) ? $nation->id[0] : $nation->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $nation->toJson();
        $crud->data_end = json_encode($nation->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Nations "deleted" event.
     *
     * @param Nation $nation
     * @return void
     */
    public static function deleted(Nation $nation)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Nation';
        $crud->model_id = is_array($nation->id) ? $nation->id[0] : $nation->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $nation->toJson();
        $crud->data_end = json_encode($nation->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Nations "restored" event.
     *
     * @param Nation $nation
     * @return void
     */
    public static function restored(Nation $nation)
    {
//
    }

    /**
     * Handle the Nations "force deleted" event.
     *
     * @param Nation $nation
     * @return void
     */
    public static function forceDeleted(Nation $nation)
    {
//


    }
}
