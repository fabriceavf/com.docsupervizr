<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UtilisateurController extends Controller
{
//    public function index()
//    {
//        return response()
//        ->json($Table = User::where('type', 'employe')->orderBy('matricule', 'ASC')->get())
//        ->withNations($Nations = Nation::orderBy('libelle', 'ASC')->get())
//        ->withFonctions($Fonction = Fonction::orderBy('libelle', 'ASC')->get())
//        ;
//    }
    public function index()
    {
        return response()->json($Table = User::where('type_id', '2')->orderBy('matricule', 'ASC')->get());
    }

    public function get_enrolements()
    {
        return response()
            ->json($Table = User::where('type', 'employe')->orderBy('matricule', 'ASC')->get());
    }

    public function store(Request $request)
    {
        $nom = Str::upper($request->input('nom'));
        $prenom = Str::title($request->input('prenom'));

        Validator::make($request->all(), [
            'nom' => ['required'],
            'prenom' => ['required', Rule::unique('users')->where(function ($query) use ($nom, $prenom) {
                return $query->where('nom', $nom)
                    ->where('prenom', $prenom);
            })],
            'nationalite' => ['required'],
            //'telephone1' => ['regex:/^([0-9\s\-\+\(\)]*)$/','min:8'],
            //'telephone2' => ['regex:/^([0-9\s\-\+\(\)]*)$/','min:8'],
            'sexe' => ['required'],
            'matricule' => ['required', 'min:1', Rule::unique('users')],
            //'photo' => 'required',

        ], $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prenom est obligatoire.',
            'prenom.unique' => 'Ce nom et ce prénom sont déjà utilisés.',
            'nationalite.required' => 'La nationalite est obligatoire.',
            'sexe.required' => 'Le sexe est obligatoire.',
            'matricule.required' => 'Le matricule est obligatoire.',
        ])->validate();

        $agent = User::create($request->all());

        // $msg = 'enrolé l\'agent '.$agent->matricule.' '.$agent->nom.' '.$agent->prenom;

        /*if ($request->photo) {
            $photo = $request->photo;

            $base64Image = explode(";base64,",  $photo);
            $explodeImage = explode("image/", $base64Image[0]);
            $imageType = $explodeImage[1];
            $image_base64 = base64_decode($base64Image[1]);

            //$photo_file = Str::slug($agent->nom, '_').Str::random(5).'_'.$agent->id.'.'.$photo->getClientOriginalExtension();
            $photo_file = 'photos/'.Str::slug($agent->nom, '_').Str::random(5).'_'.$agent->id.'.'.$imageType;

            file_put_contents($photo_file, $image_base64);
            //$agent->photo = $photo->storeAs('photos', $photo_file);
            $agent->photo = $photo_file;
            $agent->update();

            //$img = Image::make(storage_path("/app/{$agent->photo}"))->fit(1200, 1200);
            //$img->save();

            $msg = $msg.' (photo importé)';
        }

        elseif ($request->picture) {
            $imgName = Str::slug($agent->nom, '_').Str::random(5).'_'.$agent->id.'.png';
            \Image::make($request->picture)->save(storage_path("/app/photos/{$imgName}"));

            $agent->photo = 'photos/'.$imgName;
            $agent->update();

            $img = Image::make(storage_path("/app/{$agent->photo}"))->fit(1200, 1200);
            $img->save();

            $msg = $msg.' (photo capturé par webcam)';
        }*/
    }

    public function update(Request $request, $id)
    {
        $nom = Str::upper($request->input('nom'));
        $prenom = Str::title($request->input('prenom'));

        Validator::make($request->all(), [
            'nom' => ['required'],
            'prenom' => ['required', Rule::unique('users')->where(function ($query) use ($nom, $prenom) {
                return $query->where('nom', $nom)
                    ->where('prenom', $prenom);
            })->ignore($id)],
            //'telephone1' => ['regex:/^([0-9\s\-\+\(\)]*)$/','min:8'],
            //'telephone2' => ['regex:/^([0-9\s\-\+\(\)]*)$/','min:8'],
            'matricule' => ['required', 'min:1', Rule::unique('users')->ignore($id)],
            //'photo' => 'required',

        ], $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prenom est obligatoire.',
            'prenom.unique' => 'Ce nom et ce prénom sont déjà utilisés.',
        ])->validate();

        $agent = User::find($id);
        $agent->update($request->all());

        // $msg = 'enrolé l\'agent '.$agent->matricule.' '.$agent->nom.' '.$agent->prenom;

        /* if ($request->photo) {
             $photo = $request->photo;

             $base64Image = explode(";base64,",  $photo);
             $explodeImage = explode("image/", $base64Image[0]);
             $imageType = $explodeImage[1];
             $image_base64 = base64_decode($base64Image[1]);

             //$photo_file = Str::slug($agent->nom, '_').Str::random(5).'_'.$agent->id.'.'.$photo->getClientOriginalExtension();
             $photo_file = 'photos/'.Str::slug($agent->nom, '_').Str::random(5).'_'.$agent->id.'.'.$imageType;

             file_put_contents($photo_file, $image_base64);
             //$agent->photo = $photo->storeAs('photos', $photo_file);
             $agent->photo = $photo_file;
             $agent->update();

             //$img = Image::make(storage_path("/app/{$agent->photo}"))->fit(1200, 1200);
             //$img->save();

             $msg = $msg.' (photo importé)';
         }

         elseif ($request->picture) {
             $imgName = Str::slug($agent->nom, '_').Str::random(5).'_'.$agent->id.'.png';
             \Image::make($request->picture)->save(storage_path("/app/photos/{$imgName}"));

             $agent->photo = 'photos/'.$imgName;
             $agent->update();

             $img = Image::make(storage_path("/app/{$agent->photo}"))->fit(1200, 1200);
             $img->save();

             $msg = $msg.' (photo capturé par webcam)';
         }*/
    }
}
