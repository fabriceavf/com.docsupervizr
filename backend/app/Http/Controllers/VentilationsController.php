<?php

namespace App\Http\Controllers;

use App\Models\GroupesModel;
use App\Models\UsersModel;
use App\Models\ventilations;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class VentilationsController extends Controller
{


    public function index()
    {
        return response()
            ->withVentilations($ventilations = ventilations::orderBy('id', 'ASC')->get());

    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [


            'id' => [],


            'mois' => ['required'],


            'user_id' => [],


            'total' => ['required'],


            'statut' => [],


            'extra_attributes' => [],


            'created_at' => [],


            'updated_at' => [],


        ], $messages = [


            'mois.required' => 'Cette donnee ne peut etre vide.',


            'total.required' => 'Cette donnee ne peut etre vide.',


        ])->validate();

        $Ventilations = new ventilations;


        $Ventilations->mois = $request->input('mois') ?? "";


        $Ventilations->total = $request->input('total') ?? "";


        $Ventilations->statut = $request->input('statut') ?? "";


        $Ventilations->save();


        return redirect()->route('ventilations.index')->withSuccess($success = 'Nouvelle Ventilations ajouté');
    }

    public function update(Request $request, ventilations $Ventilations)
    {
        Validator::make($request->all(), [


            'id' => [],


            'mois' => ['required'],


            'user_id' => [],


            'total' => ['required'],


            'statut' => [],


            'extra_attributes' => [],


            'created_at' => [],


            'updated_at' => [],


        ], $messages = [


            'mois.required' => 'Cette donnee ne peut etre vide.',


            'total.required' => 'Cette donnee ne peut etre vide.',


        ])->validate();


        $Ventilations->mois = $request->input('mois') ?? "";


        $Ventilations->total = $request->input('total') ?? "";


        $Ventilations->statut = $request->input('statut') ?? "";


        $Ventilations->save();


        return redirect()->route('ventilations.index')->withSuccess($success = 'Ventilations modifié');
    }

    public function show($id)
    {
        return $Ventilations = ventilations::find($id);
    }


    public function destroy(Request $request, ventilations $Ventilations)
    {

        $Ventilations->delete();


        return redirect()->route('ventilations.index')->withSuccess($success = 'Ventilations supprimés');
    }


    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(ventilations::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('mois'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('total'),


                AllowedFilter::exact('statut'),


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


        $data = QueryBuilder::for(ventilations::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('mois'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('total'),


                AllowedFilter::exact('statut'),


            ])
            ->get();

        $donnees = $data;
        $donnees = $donnees->toArray();


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


}



