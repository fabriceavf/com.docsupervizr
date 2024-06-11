<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\ValidationsModel;
use App\Models\prod\Ville;
use App\Validations\VillesValidation;
use Illuminate\Support\Facades\Auth;


class VillesObservers
{
    /**
     * Handle the Villes "created" event.
     *
     * @param Ville $ville
     * @return void
     */
    public static function created(Ville $ville)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Ville';
        $crud->model_id = is_array($ville->id) ? $ville->id[0] : $ville->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $ville->toJson();
        $crud->data_end = json_encode($ville->getAttributes());
        $crud->save();


        $ville->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'villes'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $ville->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\VillesValidation')) {

            VillesValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\VillesValidation')) {
            VillesValidation::after($pipeline);

        }


    }

    /**
     * Handle the Villes "updated" event.
     *
     * @param Ville $ville
     * @return void
     */
    public static function updated(Ville $ville)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Ville';
        $crud->model_id = is_array($ville->id) ? $ville->id[0] : $ville->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $ville->toJson();
        $crud->data_end = json_encode($ville->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Villes "deleted" event.
     *
     * @param Ville $ville
     * @return void
     */
    public static function deleted(Ville $ville)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Ville';
        $crud->model_id = is_array($ville->id) ? $ville->id[0] : $ville->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $ville->toJson();
        $crud->data_end = json_encode($ville->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Villes "restored" event.
     *
     * @param Ville $ville
     * @return void
     */
    public static function restored(Ville $ville)
    {
//
    }

    /**
     * Handle the Villes "force deleted" event.
     *
     * @param Ville $ville
     * @return void
     */
    public static function forceDeleted(Ville $ville)
    {
//


    }
}
