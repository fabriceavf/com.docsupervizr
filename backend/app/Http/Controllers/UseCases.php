<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UseCases extends Controller
{


    public function create(Request $request)
    {

        $data = $request->all();
        $name = $request->get('action', 'rien');
        $data['__can__'] = true;
        $data['__result__'] = [];
        $data['__valide__'] = true;
        $data['__headers__'] = $request->headers->all();
        $data['__authId__'] = Auth::id();
        $data['__errorsValidations__'] = [];
        $data['__ip__'] = $request->ip();

        $folders = ['systems', 'auto', 'customs'];
        $actions = ['can', "validate", 'before', 'exec', "after"];
        $classSelectionner = [];
        $classNonSelectionner = [];

        foreach ($folders as $folder) {
            foreach ($actions as $act) {
                $classe = "\\App\useCases\\" . $folder . "\\$name" . ucfirst($act) . "UseCase";
//                dump($classe);
                if (
                    class_exists($classe) && method_exists($classe, 'exec')
                ) {
                    $classSelectionner[$act] = $classe;
                } else {
                    $classNonSelectionner[$act] = $classe;
                }
            }
        }
//        dump($classSelectionner);
        if (count($classSelectionner) == count($actions)) {
            foreach ($classSelectionner as $key => $classe) {
//                try{
//                    dump($classe);
//                    dump($data);
//                Si je veux valider je doit avec can a true
                if (in_array($key, ["validate"]) and (!array_key_exists('__can__', $data) or $data['__can__'] != true)) {
                    break;
                }
//                Si je veux 'before', 'exec', "after"je doit avec can a true
                if (in_array($key, ['before', 'exec', "after"]) and (!array_key_exists('__valide__', $data) or $data['__valide__'] != true)) {
                    break;
                }
                $data = $classe::exec($data);
//                }
//                catch (\Throwable $e){
//                    dump($e);
//                }
//                dump($classe);
//                dump($data);
            }
        } else {
            dump('impossible dexcecuter cette useCase');
        }
//        dd($classSelectionner);
        if (array_key_exists('__errorsValidations__', $data) && is_array($data['__errorsValidations__']) && count($data['__errorsValidations__']) > 0) {
            return response()->json(['error' => $data['__errorsValidations__']], 401);
        } else {
            return response()->json($data['__result__'], 200);
        }


    }

}
