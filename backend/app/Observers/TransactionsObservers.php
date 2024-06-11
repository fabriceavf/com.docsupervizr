<?php

namespace App\Observers;

use App\Models\prod\CrudsModel;
use App\Models\prod\Transaction;
use App\Models\prod\ValidationsModel;
use App\Validations\TransactionsValidation;
use Illuminate\Support\Facades\Auth;


class TransactionsObservers
{
    /**
     * Handle the Transactions "created" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public static function created(Transaction $transaction)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Transaction';
        $crud->model_id = is_array($transaction->id) ? $transaction->id[0] : $transaction->id;
        $crud->users = Auth::id();
        $crud->actions = 'create';
        $crud->data_first = $transaction->toJson();
        $crud->data_end = json_encode($transaction->getAttributes());
        $crud->save();


        $transaction->Myresource()->create([]);

//  je recupere toute les etapes de validations
        $validations = ValidationsModel::where([
            'table' => 'transactions'
        ])->get();
//  je CREER UNE PIPELINE POUR LA RESSOUCE
        $pipeline = $transaction->Myresource->first()->resourcespipelines()->create([
            "pipelines" => "Pepilines creer par le systeme"
        ]);

        if (class_exists('\App\Validations\TransactionsValidation')) {

            TransactionsValidation::before($pipeline);

        }

//        ET POUR CHAQUE ETAPE DE LA VALIADATION JE LAR RAJOUTE A LA PIPELINE DE LA RESSOURCE
        foreach ($validations as $validation) {
            $pipeline->resourcesprogressions()->create([
                'valideurs' => implode(',', $validation->validateurs),
                'etats' => 'WAITING',
                'steps' => $validation->etapes
            ]);
        }

        if (class_exists('\App\Validations\TransactionsValidation')) {
            TransactionsValidation::after($pipeline);

        }


    }

    /**
     * Handle the Transactions "updated" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public static function updated(Transaction $transaction)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Transaction';
        $crud->model_id = is_array($transaction->id) ? $transaction->id[0] : $transaction->id;
        $crud->users = Auth::id();
        $crud->actions = 'edition';
        $crud->data_first = $transaction->toJson();
        $crud->data_end = json_encode($transaction->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Transactions "deleted" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public static function deleted(Transaction $transaction)
    {
        $crud = new CrudsModel();
        $crud->models = '\App\Models\prod\Transaction';
        $crud->model_id = is_array($transaction->id) ? $transaction->id[0] : $transaction->id;
        $crud->users = Auth::id();
        $crud->actions = 'delete';
        $crud->data_first = $transaction->toJson();
        $crud->data_end = json_encode($transaction->getAttributes());
        $crud->save();


    }

    /**
     * Handle the Transactions "restored" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public static function restored(Transaction $transaction)
    {
//
    }

    /**
     * Handle the Transactions "force deleted" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public static function forceDeleted(Transaction $transaction)
    {
//


    }
}
