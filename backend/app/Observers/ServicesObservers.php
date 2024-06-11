<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\Service;
use App\Models\prod\ValidationsModel;
use App\Validations\ServicesValidation;
use Illuminate\Support\Facades\Auth;


class ServicesObservers
{
    /**
     * Handle the Services "created" event.
     *
     * @param Service $service
     * @return void
     */
    public static function created(Service $service)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Service';
        $crud->model_id = is_array($service->id) ? $service->id[0] : $service->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $service->toJson();
        $crud->data_end = json_encode($service->getAttributes());
        $crud->save();


        $service->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'services'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $service->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\ServicesValidation')) {

            ServicesValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\ServicesValidation')) {
            ServicesValidation::after($pipeline);

        }


    }

    /**
     * Handle the Services "updated" event.
     *
     * @param Service $service
     * @return void
     */
    public static function updated(Service $service)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Service';
        $crud->model_id = is_array($service->id) ? $service->id[0] : $service->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $service->toJson();
        $crud->data_end = json_encode($service->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Services "deleted" event.
     *
     * @param Service $service
     * @return void
     */
    public static function deleted(Service $service)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Service';
        $crud->model_id = is_array($service->id) ? $service->id[0] : $service->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $service->toJson();
        $crud->data_end = json_encode($service->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Services "restored" event.
     *
     * @param Service $service
     * @return void
     */
    public static function restored(Service $service)
    {
//
    }

    /**
     * Handle the Services "force deleted" event.
     *
     * @param Service $service
     * @return void
     */
    public static function forceDeleted(Service $service)
    {
//


    }
}
