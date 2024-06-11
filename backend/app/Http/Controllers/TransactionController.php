<?php

namespace App\Http\Controllers;

use App\Models\biotime\IclockTransactionModel;
use App\Models\Pointage;
use App\Models\User;
use App\Models\Ventilation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PointageController extends Controller
{

    public function index()
    {


        return response()
            ->json($Table = Pointage::where('debut_realise', '!=', NULL)->orderBy('debut_realise', 'DESC')->get())
            ->withEmployes($Employes = User::where('type', 'employe')->orderBy('matricule', 'ASC')->get());
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
            'libelle' => ['required'],
            'service_id' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.'
        ])->validate();

        $line = Pointage::create($request->all());

        return $line;
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
            'libelle' => ['required'],
            'service_id' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.'
        ])->validate();

        $line = Pointage::find($id);
        $line->update($request->all());

        return $line;
    }

    public function destroy($id)
    {
        $line = Pointage::find($id);
        $line->delete();
    }

    public function get_exceptions()
    {
        return response()
            ->json($Table = Pointage::where('volume_realise', '>', 8)->where('est_valide', '=', 0)->get());
    }

    public function get_absences()
    {
        return response()
            ->json($Table = Pointage::where('est_attendu', 1)->where('debut_realise', null)->where('fin_realise', null)->get());
    }

    public function get_ventilations()
    {
        return response()
            ->json($Table = Ventilation::latest()->get());
    }

    private function getAllPlageForUser()
    {
        $result = [];
        $pointages = Pointage::all();

        foreach ($pointages as $poin) {
            $debut = Carbon::parse($poin['debut_prevu']);
            $fin = Carbon::parse($poin['fin_prevu']);
            $year = $fin->year;
            $month = $fin->month;
            $days = $fin->day;
            $date = \Illuminate\Support\Carbon::create($year, $month, $days)->endOfDay();
            $nextDate = Pointage::where('id', '>', $poin->id)
                ->where('user_id', $poin->user_id)
                ->first();
            $type = $fin->diffInDays($debut) == 0 ? "jour" : 'nuit';
            $diff = $fin->diffInHours($debut);
            $diff = $diff / 2;
            $limit = clone($fin);
            $limit->addHours($diff);
            if (!empty($nextDate) && !empty($nextDate->debut_prevu)) {
                $diff = $fin->diffInHours($nextDate->debut_prevu);
                $ecart = $diff / 2;

                $limit = Carbon::parse($nextDate->debut_prevu)->subHours($ecart);

            }


            $backDate = Pointage::where('id', '<', $poin->id)
                ->where('user_id', $poin->user_id)
                ->orderBy('id', 'desc')
                ->first();
            $depart = clone($debut);
            $depart->subHours($diff);
            if (!empty($backDate) && !empty($backDate->fin_prevu)) {
                $diff = $debut->diffInHours($backDate->fin_prevu);
                $ecart = $diff / 2;

                $depart = clone ($debut)->subHours($ecart);

            }

            $result[] = [$depart->format('Y-m-d H:i:s'), $limit->format('Y-m-d H:i:s'), $poin->user_id];
            $poin->extra_attributes->min = $depart->format('Y-m-d H:i:s');
            $poin->extra_attributes->max = $limit->format('Y-m-d H:i:s');
            $poin->save();


        }
//            dd($result);


    }

    private function getPointeuseData()
    {

        $pointeuse = IclockTransactionModel::orderBy('id')->get();
        foreach ($pointeuse as $pointa) {
            $date = Carbon::parse($pointa['punch_time'])->format('Y-m-d');
            $debut = Carbon::parse($pointa['punch_time']);

            $debut->setHour(0);
            $debut->setSecond(0);
            $debut->setMinute(0);
            $fin = Carbon::parse($pointa['punch_time']);
            $fin->setHour(23);
            $fin->setSecond(59);
            $fin->setMinute(59);
            $exist = Pointage::where(function ($q) use ($date) {
                $q
                    ->where('debut_prevu', 'LIKE', '%' . $date . '%')
                    ->orWhere('fin_prevu', 'LIKE', '%' . $date . '%');
            })
                ->where('emp_code', $pointa['emp_code'])->first();
//            dd($exist);
            if (empty($exist)) {
                $user = User::where('emp_code', $pointa['emp_code'])->first();
                if (!empty($user)) {
                    $el = Pointage::create([
                        'pointeuse' => $pointa['terminal_alias'],
                        'lieu' => '',
                        'debut_prevu' => $debut->format('Y-m-d'),
                        'fin_prevu' => $fin->format('Y-m-d'),
                        'faction_horaire' => '',
                        'debut_realise' => now(),
                        'fin_realise' => now(),
                        'volume_realise' => '',
                        'emp_code' => $pointa['emp_code'],
                        'actif' => 1,
                        'user_id' => $user->id,
                        'est_attendu' => 1,
                        'est_valide' => 1,
                    ]);
                    $el->extra_attributes->auto = "yes";
                    $el->save();
                }

//                dd($el);


//                dd('on doit creer',$pointa->toArray());
            }

//            dd($pointa->toArray());
        }

        $pointages = Pointage::all();
        foreach ($pointages as $poin) {

            $depart = Carbon::parse($poin->extra_attributes->min);
            $limit = Carbon::parse($poin->extra_attributes->max);
//                    dd($poin->extra_attributes->min,$poin->extra_attributes->max);
            $pointageSelect = IclockTransactionModel::where('emp_code', $poin['emp_code'])
                ->where('punch_time', '>=', $depart)
                ->where('punch_time', '<=', $limit)
                ->get()->toArray();
            $poin->extra_attributes->pointages = $pointageSelect;

            if (Carbon::now() < $depart && Carbon::now() < $limit) {
                //               dump('ca na pas encore commencer');
                $poin->extra_attributes->statut = "Non Demarrer";
            }
            if (Carbon::now() > $depart && Carbon::now() > $limit) {
                //               dump('cest terminer');
                $poin->extra_attributes->statut = "Terminer";
            }
            if (Carbon::now() >= $depart && Carbon::now() <= $limit) {
                //               dump('cest en cours');
                $poin->extra_attributes->statut = "En cours";
            }

            $poin->save();


        }
        foreach ($pointeuse as $point) {
            $user_code = $point['emp_code'];
            $date = Carbon::parse($point['punch_time']);
            Pointage::where([
                'emp_code' => $user_code,
            ]);
//                    dd($point->toArray());

        }


    }
}
