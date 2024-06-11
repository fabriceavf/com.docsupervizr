<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\File;
use App\Models\prod\ValidationsModel;
use App\Validations\FilesValidation;
use Illuminate\Support\Facades\Auth;


class FilesObservers
{
    /**
     * Handle the Files "created" event.
     *
     * @param File $file
     * @return void
     */
    public static function created(File $file)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\File';
        $crud->model_id = is_array($file->id) ? $file->id[0] : $file->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $file->toJson();
        $crud->data_end = json_encode($file->getAttributes());
        $crud->save();


        $file->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'files'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $file->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\FilesValidation')) {

            FilesValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\FilesValidation')) {
            FilesValidation::after($pipeline);

        }


    }

    /**
     * Handle the Files "updated" event.
     *
     * @param File $file
     * @return void
     */
    public static function updated(File $file)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\File';
        $crud->model_id = is_array($file->id) ? $file->id[0] : $file->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $file->toJson();
        $crud->data_end = json_encode($file->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Files "deleted" event.
     *
     * @param File $file
     * @return void
     */
    public static function deleted(File $file)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\File';
        $crud->model_id = is_array($file->id) ? $file->id[0] : $file->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $file->toJson();
        $crud->data_end = json_encode($file->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Files "restored" event.
     *
     * @param File $file
     * @return void
     */
    public static function restored(File $file)
    {
//
    }

    /**
     * Handle the Files "force deleted" event.
     *
     * @param File $file
     * @return void
     */
    public static function forceDeleted(File $file)
    {
//


    }
}
