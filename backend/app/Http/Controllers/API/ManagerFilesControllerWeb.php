<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZipArchive;


class ManagerFilesControllerWeb extends Controller
{


    public function __construct(Request $request)
    {

    }


    public function uploads(Request $request)
    {


        $fichiers = $request->file('upload');
        $label = $request->input("uploadField");
//            dd($fichiers,$label);

        Validator::make(
            [$label => $fichiers],
            [$label => 'required'],
            [
                'required' => "veuillez choisir un fichier",
                'mimes' => "veuillez choisir un fichier excel",
            ]
        )->validate();

        $disk = Storage::build([
            'driver' => 'local',
            'root' => public_path(),
        ]);
        $path = $disk->put("upload", $request->file('upload'));
        $files = new File();
        $files->old_name = $fichiers->getClientOriginalName();
        $files->new_name = $fichiers->hashName();
        $files->extensions = $fichiers->extension();
        $files->descriptions = "fichier contenant la liste des produits a mettre a jour en fonction de lauer aspersorances";
        $files->size = $fichiers->getSize();
        $files->path = $path;
        $files->web_path = $path;
        $files->save();


        return response()->json($files, 200);

    }

    public function uploads_files(Request $request)
    {


        $fichiers = $request->file('file');
        $label = 'Fichiers';
//            dd($fichiers,$label);

        $validator = Validator::make(
            [$label => $fichiers],
            [$label => 'required'],
            [
                'required' => "veuillez choisir un fichier",
                'mimes' => "veuillez choisir un fichier images",
                $label . '.max' => "veuillez choisir inferieur a 10M",
            ]
        );
        if ($validator->fails()) {
            $data = [];
            $data['data'] = [];
            $data['fieldErrors'] = [];
            foreach ($validator->errors()->toArray() as $key => $error) {

                $dat['name'] = $key;
                $dat['status'] = $error[0];
                $data['fieldErrors'][] = $dat;

            }

//
        } else {
            $disk = Storage::build([
                'driver' => 'local',
                'root' => public_path(),
            ]);
//            dd($fichiers->extension(),$fichiers->hashName());
            $path = $disk->put('upload', $request->file('file'));
            $files = new File();
            $files->old_name = $fichiers->getClientOriginalName();
            $files->new_name = $fichiers->hashName();
            $files->extensions = $fichiers->extension() ?? "";
            $files->descriptions = "fichier contenant la liste des produits a mettre a jour en fonction de lauer aspersorances";
            $files->size = $fichiers->getSize();
            $files->path = "upload/" . $fichiers->hashName();
            $files->web_path = "upload/" . $fichiers->hashName();
            $files->save();

            $data = $files->toArray();


            return response()->json($data, 200);


        }
        return response()->json($data, 419);
    }

    public function uploads_get_base(Request $request)
    {
        return response()->json(['data' => []], 200);
    }

    public function uploads_get_specific(Request $request, $fichiers)
    {
        $fichiers = explode(',', $fichiers);

//        dd($fichier);
        $response = [];
        foreach ($fichiers as $fichier) {
            $result = File::find($fichier);
            $response['data'][] = !empty($result) ? $result->toArray() : [];
        }
        return response()->json($response, 200);

    }

    public function download(Request $request, $fichiers)
    {

        //PDF file is stored under project/public/download/info.pdf
//        $file= public_path(). "/download/info.pdf";

//        $headers = array(
//            'Content-Type: application/pdf',
//        );
//
//        return Response::download($file, 'filename.pdf', $headers);
        $fichiers = explode(',', $fichiers);
        $new_files = [];
        foreach ($fichiers as $files) {
//            dd($files);
            $new_files[] = File::find($files)->toArray();

        }
        $disk = Storage::build([
            'driver' => 'local',
            'root' => public_path(),
        ]);
        $headers = ['Content-Type: files'];
        $zip = new ZipArchive();
        $fileName = 'test.zip';
        $fileName = 'upload/FichierJoin' . now()->timestamp . '.zip';


        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {


            foreach ($new_files as $key => $value) {
//                 dd($value);
                $zip->addFile(public_path($value['path']), $value['new_name']);
            }
            $zip->close();

        }
        if (count($new_files) > 1) {
            return response()->download(public_path($fileName));

        }
        if (count($new_files) == 1) {
            return response()->download(public_path($new_files[0]['web_path']), $new_files[0]['old_name']);

        }


//        return \Response::download($new_files[0], 'plugin.jpg', $headers);
//        dd($new_files);
//        return Storage::download('images/test.jpg');

    }

}



