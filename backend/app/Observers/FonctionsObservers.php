<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\Fonction;
use App\Models\prod\ValidationsModel;
use App\Validations\FonctionsValidation;
use Illuminate\Support\Facades\Auth;


class FonctionsObservers
{
    /**
     * Handle the Fonctions "created" event.
     *
     * @param Fonction $fonction
     * @return void
     */
    public static function created(Fonction $fonction)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Fonction';
        $crud->model_id = is_array($fonction->id) ? $fonction->id[0] : $fonction->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $fonction->toJson();
        $crud->data_end = json_encode($fonction->getAttributes());
        $crud->save();


        $fonction->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'fonctions'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $fonction->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\FonctionsValidation')) {

            FonctionsValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\FonctionsValidation')) {
            FonctionsValidation::after($pipeline);

        }


    }

    /**
     * Handle the Fonctions "updated" event.
     *
     * @param Fonction $fonction
     * @return void
     */
    public static function updated(Fonction $fonction)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Fonction';
        $crud->model_id = is_array($fonction->id) ? $fonction->id[0] : $fonction->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $fonction->toJson();
        $crud->data_end = json_encode($fonction->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Fonctions "deleted" event.
     *
     * @param Fonction $fonction
     * @return void
     */
    public static function deleted(Fonction $fonction)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Fonction';
        $crud->model_id = is_array($fonction->id) ? $fonction->id[0] : $fonction->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $fonction->toJson();
        $crud->data_end = json_encode($fonction->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Fonctions "restored" event.
     *
     * @param Fonction $fonction
     * @return void
     */
    public static function restored(Fonction $fonction)
    {
//
    }

    /**
     * Handle the Fonctions "force deleted" event.
     *
     * @param Fonction $fonction
     * @return void
     */
    public static function forceDeleted(Fonction $fonction)
    {
//


    }
}
