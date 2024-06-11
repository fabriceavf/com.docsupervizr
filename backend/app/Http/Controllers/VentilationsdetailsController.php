<?php

namespace App\Http\Controllers;

use App\Models\GroupesModel;
use App\Models\UsersModel;
use App\Models\ventilationsdetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class VentilationsdetailsController extends Controller
{


    public function index()
    {
        return response()
            ->withVentilationsdetails($ventilationsdetails = ventilationsdetails::orderBy('libelle', 'ASC')->get());

    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [


            'id' => [],


            'ventilation_id' => ['required'],


            'user_id' => [],


            'semaine' => ['required'],


            'dimanche' => ['required'],


            'lundi' => ['required'],


            'mardi' => ['required'],


            'mercredi' => ['required'],


            'jeudi' => ['required'],


            'vendredi' => ['required'],


            'samedi' => ['required'],


            'hn' => ['required'],


            'hs15' => ['required'],


            'hs26' => ['required'],


            'hs55' => ['required'],


            'hs30' => ['required'],


            'hs60' => ['required'],


            'hs115' => ['required'],


            'hs130' => ['required'],


            'total' => ['required'],


            'extra_attributes' => [],


            'created_at' => [],


            'updated_at' => [],


        ], $messages = [


            'ventilation_id.required' => 'Cette donnee ne peut etre vide.',


            'semaine.required' => 'Cette donnee ne peut etre vide.',


            'dimanche.required' => 'Cette donnee ne peut etre vide.',


            'lundi.required' => 'Cette donnee ne peut etre vide.',


            'mardi.required' => 'Cette donnee ne peut etre vide.',


            'mercredi.required' => 'Cette donnee ne peut etre vide.',


            'jeudi.required' => 'Cette donnee ne peut etre vide.',


            'vendredi.required' => 'Cette donnee ne peut etre vide.',


            'samedi.required' => 'Cette donnee ne peut etre vide.',


            'hn.required' => 'Cette donnee ne peut etre vide.',


            'hs15.required' => 'Cette donnee ne peut etre vide.',


            'hs26.required' => 'Cette donnee ne peut etre vide.',


            'hs55.required' => 'Cette donnee ne peut etre vide.',


            'hs30.required' => 'Cette donnee ne peut etre vide.',


            'hs60.required' => 'Cette donnee ne peut etre vide.',


            'hs115.required' => 'Cette donnee ne peut etre vide.',


            'hs130.required' => 'Cette donnee ne peut etre vide.',


            'total.required' => 'Cette donnee ne peut etre vide.',


        ])->validate();

        $Ventilationsdetails = new ventilationsdetails;


        $Ventilationsdetails->ventilation_id = $request->input('ventilation_id') ?? "";


        $Ventilationsdetails->semaine = $request->input('semaine') ?? "";


        $Ventilationsdetails->dimanche = $request->input('dimanche') ?? "";


        $Ventilationsdetails->lundi = $request->input('lundi') ?? "";


        $Ventilationsdetails->mardi = $request->input('mardi') ?? "";


        $Ventilationsdetails->mercredi = $request->input('mercredi') ?? "";


        $Ventilationsdetails->jeudi = $request->input('jeudi') ?? "";


        $Ventilationsdetails->vendredi = $request->input('vendredi') ?? "";


        $Ventilationsdetails->samedi = $request->input('samedi') ?? "";


        $Ventilationsdetails->hn = $request->input('hn') ?? "";


        $Ventilationsdetails->hs15 = $request->input('hs15') ?? "";


        $Ventilationsdetails->hs26 = $request->input('hs26') ?? "";


        $Ventilationsdetails->hs55 = $request->input('hs55') ?? "";


        $Ventilationsdetails->hs30 = $request->input('hs30') ?? "";


        $Ventilationsdetails->hs60 = $request->input('hs60') ?? "";


        $Ventilationsdetails->hs115 = $request->input('hs115') ?? "";


        $Ventilationsdetails->hs130 = $request->input('hs130') ?? "";


        $Ventilationsdetails->total = $request->input('total') ?? "";


        $Ventilationsdetails->save();


        return redirect()->route('ventilationsdetails.index')->withSuccess($success = 'Nouvelle Ventilationsdetails ajouté');
    }

    public function update(Request $request, ventilationsdetails $Ventilationsdetails)
    {
        Validator::make($request->all(), [


            'id' => [],


            'ventilation_id' => ['required'],


            'user_id' => [],


            'semaine' => ['required'],


            'dimanche' => ['required'],


            'lundi' => ['required'],


            'mardi' => ['required'],


            'mercredi' => ['required'],


            'jeudi' => ['required'],


            'vendredi' => ['required'],


            'samedi' => ['required'],


            'hn' => ['required'],


            'hs15' => ['required'],


            'hs26' => ['required'],


            'hs55' => ['required'],


            'hs30' => ['required'],


            'hs60' => ['required'],


            'hs115' => ['required'],


            'hs130' => ['required'],


            'total' => ['required'],


            'extra_attributes' => [],


            'created_at' => [],


            'updated_at' => [],


        ], $messages = [


            'ventilation_id.required' => 'Cette donnee ne peut etre vide.',


            'semaine.required' => 'Cette donnee ne peut etre vide.',


            'dimanche.required' => 'Cette donnee ne peut etre vide.',


            'lundi.required' => 'Cette donnee ne peut etre vide.',


            'mardi.required' => 'Cette donnee ne peut etre vide.',


            'mercredi.required' => 'Cette donnee ne peut etre vide.',


            'jeudi.required' => 'Cette donnee ne peut etre vide.',


            'vendredi.required' => 'Cette donnee ne peut etre vide.',


            'samedi.required' => 'Cette donnee ne peut etre vide.',


            'hn.required' => 'Cette donnee ne peut etre vide.',


            'hs15.required' => 'Cette donnee ne peut etre vide.',


            'hs26.required' => 'Cette donnee ne peut etre vide.',


            'hs55.required' => 'Cette donnee ne peut etre vide.',


            'hs30.required' => 'Cette donnee ne peut etre vide.',


            'hs60.required' => 'Cette donnee ne peut etre vide.',


            'hs115.required' => 'Cette donnee ne peut etre vide.',


            'hs130.required' => 'Cette donnee ne peut etre vide.',


            'total.required' => 'Cette donnee ne peut etre vide.',


        ])->validate();


        $Ventilationsdetails->ventilation_id = $request->input('ventilation_id') ?? "";


        $Ventilationsdetails->semaine = $request->input('semaine') ?? "";


        $Ventilationsdetails->dimanche = $request->input('dimanche') ?? "";


        $Ventilationsdetails->lundi = $request->input('lundi') ?? "";


        $Ventilationsdetails->mardi = $request->input('mardi') ?? "";


        $Ventilationsdetails->mercredi = $request->input('mercredi') ?? "";


        $Ventilationsdetails->jeudi = $request->input('jeudi') ?? "";


        $Ventilationsdetails->vendredi = $request->input('vendredi') ?? "";


        $Ventilationsdetails->samedi = $request->input('samedi') ?? "";


        $Ventilationsdetails->hn = $request->input('hn') ?? "";


        $Ventilationsdetails->hs15 = $request->input('hs15') ?? "";


        $Ventilationsdetails->hs26 = $request->input('hs26') ?? "";


        $Ventilationsdetails->hs55 = $request->input('hs55') ?? "";


        $Ventilationsdetails->hs30 = $request->input('hs30') ?? "";


        $Ventilationsdetails->hs60 = $request->input('hs60') ?? "";


        $Ventilationsdetails->hs115 = $request->input('hs115') ?? "";


        $Ventilationsdetails->hs130 = $request->input('hs130') ?? "";


        $Ventilationsdetails->total = $request->input('total') ?? "";


        $Ventilationsdetails->save();


        return redirect()->route('ventilationsdetails.index')->withSuccess($success = 'Ventilationsdetails modifié');
    }

    public function show($id)
    {
        return $Ventilationsdetails = ventilationsdetails::find($id);
    }


    public function destroy(Request $request, ventilationsdetails $Ventilationsdetails)
    {

        $Ventilationsdetails->delete();


        return redirect()->route('ventilationsdetails.index')->withSuccess($success = 'Ventilationsdetails supprimés');
    }


    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(ventilationsdetails::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('ventilation_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('dimanche'),


                AllowedFilter::exact('lundi'),


                AllowedFilter::exact('mardi'),


                AllowedFilter::exact('mercredi'),


                AllowedFilter::exact('jeudi'),


                AllowedFilter::exact('vendredi'),


                AllowedFilter::exact('samedi'),


                AllowedFilter::exact('hn'),


                AllowedFilter::exact('hs15'),


                AllowedFilter::exact('hs26'),


                AllowedFilter::exact('hs55'),


                AllowedFilter::exact('hs30'),


                AllowedFilter::exact('hs60'),


                AllowedFilter::exact('hs115'),


                AllowedFilter::exact('hs130'),


                AllowedFilter::exact('total'),


            ])
            ->get();

        $donnees = $data;
        $donnees = $donnees->toArray();


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(ventilationsdetails::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('ventilation_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('dimanche'),


                AllowedFilter::exact('lundi'),


                AllowedFilter::exact('mardi'),


                AllowedFilter::exact('mercredi'),


                AllowedFilter::exact('jeudi'),


                AllowedFilter::exact('vendredi'),


                AllowedFilter::exact('samedi'),


                AllowedFilter::exact('hn'),


                AllowedFilter::exact('hs15'),


                AllowedFilter::exact('hs26'),


                AllowedFilter::exact('hs55'),


                AllowedFilter::exact('hs30'),


                AllowedFilter::exact('hs60'),


                AllowedFilter::exact('hs115'),


                AllowedFilter::exact('hs130'),


                AllowedFilter::exact('total'),


            ])
            ->get();

        $donnees = $data;
        $donnees = $donnees->toArray();


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


}



