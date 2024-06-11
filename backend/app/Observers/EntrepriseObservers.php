<?php

namespace App\Observers;

use App\Models\Entreprise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EntrepriseObservers
{
    /**
     * Handle the Entreprises "created" event.
     *
     * @param Entreprise $entreprise
     * @return void
     */
    public static function created(Entreprise $entreprise)
    {
        self::parametreClient($entreprise);
    }

    private static function parametreClient(Entreprise $entreprise)
    {
        foreach (DB::table('entreprises')->cursor() as $ent) {

            $host = $ent->host;
            $host = Str::replace(' ', '', $host);
            $host = Str::replace('.', '', $host);
            $data = [
                'host' => $ent->db_host,
                'username' => $ent->db_user,
                'password' => $ent->db_pass,
                'modules' => explode(',', $ent->modules)
            ];
            $fileName = '/Params/' . $host . '_db.json';
            try {
                $dbConnectionParams = file_get_contents(base_path($fileName));
                $dbConnectionParams = json_decode($dbConnectionParams, true);
                if (empty($ent->db_pass)) {
                    $data['password'] = $dbConnectionParams['password'];
                }
            } catch (\Throwable $e) {

            }
            $disk = Storage::build([
                'driver' => 'local',
                'root' => base_path(),
            ]);
            $disk->put('/Params/' . $host . '_db.json', json_encode($data));

            DB::table('entreprises')->where('id', $ent->id)->update([
                'db_pass' => ""
            ]);

            $host = $entreprise->host;
            $host = Str::replace(' ', '', $host);
            $host = Str::replace('.', '', $host);

            if (!empty($entreprise->icon)) {
                $destination = public_path('logo/' . $host . '.supervizr.png');
                $destination2 = public_path($entreprise->icon);
                $path = storage_path('app/' . $entreprise->icon);
                if (file_exists($destination)) {
                    File::delete($destination);
                }
                if (file_exists($path)) {
                    File::copy($path, $destination);
                    File::copy($path, $destination2);
                }
            }
            if (!empty($entreprise->favicon)) {
                $destination = public_path('logo/' . $host . '.supervizr.ico');
                $destination2 = public_path($entreprise->favicon);
                $path = storage_path('app/' . $entreprise->favicon);

                if (file_exists($destination)) {
                    File::delete($destination);
                }
                if (file_exists($path)) {
                    File::copy($path, $destination);
                    File::copy($path, $destination2);
                }
            }
            if (!empty($entreprise->badge_arriere)) {
                $destination2 = public_path($entreprise->badge_arriere);
                $path = storage_path('app/' . $entreprise->badge_arriere);
                if (file_exists($path)) {
                    File::copy($path, $destination2);
                }
            }
            if (!empty($entreprise->badge_avant)) {
                $destination2 = public_path($entreprise->badge_avant);
                $path = storage_path('app/' . $entreprise->badge_avant);
                if (file_exists($path)) {
                    File::copy($path, $destination2);
                }
            }


        }
    }

    /**
     * Handle the Entreprises "updated" event.
     *
     * @param Entreprise $entreprise
     * @return void
     */
    public static function updated(Entreprise $entreprise)
    {
        self::parametreClient($entreprise);

        try {
            // Vérifiez si un fichier "filemodules" est présent
            if (request()->hasFile('filemodules')) {
                $file = request()->file('filemodules');

                // Créer le nom du fichier en utilisant la valeur de `form.host`
                $fileName = $entreprise->host . '_menu.json';

                // Définir le chemin de destination dans le dossier "Params"
                $destinationPath = '/Params/' . $fileName;

                // Sauvegarder le fichier dans le dossier "Params"
                $disk = Storage::build([
                    'driver' => 'local',
                    'root' => base_path(),
                ]);
                $disk->put($destinationPath, file_get_contents($file->getRealPath()));

            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Handle the Entreprises "deleted" event.
     *
     * @param Entreprise $entreprise
     * @return void
     */
    public static function deleted(Entreprise $entreprise)
    {
    }

    /**
     * Handle the Entreprises "restored" event.
     *
     * @param Entreprise $entreprise
     * @return void
     */
    public static function restored(Entreprise $entreprise)
    {
        //
    }

    /**
     * Handle the Entreprises "force deleted" event.
     *
     * @param Entreprise $entreprise
     * @return void
     */
    public static function forceDeleted(Entreprise $entreprise)
    {
        //


    }
}
