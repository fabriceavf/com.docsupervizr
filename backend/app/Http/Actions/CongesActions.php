<?php

namespace App\Http\Actions;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CongesActions
{


    public function agentsDisponibles(Request $request)
    {
        Carbon::setLocale('fr');
        $semaine = $request->get('semaine');
        $semaine = Str::lower($semaine);
        $semaine = explode('-', $semaine);
//        dd($semaine);

        $year = $semaine[0];
        $week = Str::replace('w', '', $semaine[1]);
        $allDate = [];
        $date = Carbon::now();


        $date->setISODate($year, $week);

        for ($i = 0; $i < 7; $i++) {

            if ($i == 6) {
                $date1 = Carbon::now();


                $date1->setISODate($year, $week);
                $date1->subDay(1);
                $newdate1 = clone($date1);

                $allDate[$i] = $newdate1->format('Y-m-d');

            } else {
                $newdate = clone($date);
                $allDate[$i] = $newdate->format('Y-m-d');
                $date->addDay(1);
            }
        }
//        dd($allDate);


        $occuper = [];

        foreach ($allDate as $date) {
            $actual = clone(Carbon::parse($date));
            $userOccuper = DB::table('conges')
                ->whereDate('debut', "<=", $date)
                ->whereDate('fin', '>', $date)
                ->get('user_id')
                ->map(function ($data) {
                    return $data->user_id;
                })->toArray();
            $userOccuper1 = DB::table('abscences')
                ->whereDate('debut', "<=", $date)
                ->whereDate('fin', '>', $date)
                ->get('user_id')
                ->map(function ($data) {
                    return $data->user_id;
                })->toArray();
            $userOccuper2 = DB::table('joursferies')
                ->whereDate('debut', "<=", $date)
                ->whereDate('fin', '>', $date)
                ->get();


            $occuper[$actual->dayName] = $userOccuper;
            $occuper[$actual->dayName . '_conges'] = $userOccuper;
            $occuper[$actual->dayName . '_abscences'] = $userOccuper1;
            $occuper[$actual->dayName . '_feries'] = $userOccuper2->count() > 0;
            $occuper[$actual->dayName . '_' . $date] = $userOccuper;
        }

//        dd($occuper);

        return $occuper;


    }

}
