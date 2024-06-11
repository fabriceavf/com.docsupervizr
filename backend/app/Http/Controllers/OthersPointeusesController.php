<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Throwable;


class OthersPointeusesController extends Controller
{

    /**
     */
    public function execSql(Request $request)
    {

        $sql = $request->get('sql');
        $resultat = collect([]);
        if (!empty($sql)) {
            $resultat = DB::select(DB::raw($sql));
        }
        return response()->json($resultat);


    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function arduinoTest(Request $request)
    {
        $data = $request->all();
        $data['cle'] = '15151515' . now();
        $data['url'] = $request->fullUrl();
        $pointages = collect([]);
        if ($request->has('pointage')) {
            $pointages = collect(explode(';', $request->get('pointage')));
        }

        $pointages = $pointages
            ->map(function ($data) {
                $data = Str::replace('+', '', $data);
                return explode('/', $data);
            })
            ->filter(function ($data) {
                return count($data) == 2;
            })
            ->map(function ($data, $index) {
                $timestamp = intval(trim($data[1])) / 1000;
                $donnes = [
                    'punch_date' => date('Y-m-d', $timestamp),
                    'punch_time' => date('Y-m-d H:i:s', $timestamp),
                    'areas_alias' => 'POINTEUSES_TEST',
                    'terminal_alias' => 'POINTEUSES_TEST',
                    'card_no' => $data[0],
                ];
                return $donnes;
            })->toArray();


        $result = 'vrai';

        try {
            foreach ($pointages as $pointage) {
                DB::table('transactions')->updateOrInsert([
                    'card_no' => $pointage['card_no'],
                    'punch_time' => $pointage['punch_time'],
                ], [
                    'punch_date' => $pointage['punch_date'],
                    'area_alias' => 'POINTEUSES_TEST',
                    'terminal_alias' => 'POINTEUSES_TEST',
                ]);
            }
        } catch (Throwable $e) {
            $result = 'faux';
        }


        return response($result);


//        return $result;
    }


    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public
    function login(Request $request)
    {
        $ip = $request->ip();
        try {

            $ip = $request->header('x-forwarded-for');
        } catch (Throwable $e) {
        }
        $localisatiobn = geoip()->getLocation($ip);
        $ville = $localisatiobn->city;
        $pays = $localisatiobn->country;

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'string',
            'remember_me1' => 'string'
        ]);
        $credentials = request(['email', 'password']);
        $credentials['deleted_at'] = null;
        if (Auth::attempt($credentials)) {

            $user = $request->user();
            DB::table('logs')->insert([
                'user_id' => $user->id,
                'action' => 'Connection Reussi',
                'ip' => $ip,
                'pays' => $pays,
                'ville' => $ville,
                'navigateur' => $request->header('User-Agent'),
                'created_at' => now(),
            ]);
            $_user = $user->toArray();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            Session::put('personalToken', $tokenResult->accessToken);

            // $token->expire_at=Carbon::now()->addHours(2);

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            return response()->json([
                'accessToken' => $tokenResult->accessToken,
                'tokenType' => 'Bearer',
                'userData' => $_user,
                'redirect_route' => Helpers::getHomeLinks(),

                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);

        }

        DB::table('logs')->insert([
            'action' => 'Connection Refuser ( ' . $request->get('email') . ' )',
            'ip' => $ip,
            'pays' => $pays,
            'ville' => $ville,
            'navigateur' => $request->header('User-Agent'),
            'created_at' => now(),
        ]);
        return response()->json([
            'error' => [
                'email' => 'Identifiant incorrect',
                'password' => 'Identifiant incorrect',
            ]
        ], 500);


    }

    public
    function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function getPointeuses(Request $request)
    {
        return DB::table('pointeuses')->whereNotNull('code_teleric')->pluck('code_teleric');
    }

    public function getPointeusesCode(Request $request)
    {
        return DB::table('pointeuses')->whereNotNull('code')->pluck('code');
    }

    public function getUsersBadge(Request $request)
    {
        $query = DB::table('users')->whereIn('type_id', [2, 3])->select(['num_badge', 'matricule', 'nom', 'prenom', 'photo']);

        if ($request->has('depuis')) {
            $timestamp = intval(trim($request->get('depuis'))) / 1000;
            $date = date('Y-m-d', $timestamp);

            $query->where('created_at', '>', $date)->orWhere('updated_at', '>', $date);
        }

        return $query->get();
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $ip = $request->ip();
        try {

            $ip = $request->header('x-forwarded-for');
        } catch (Throwable $e) {
        }
        $localisatiobn = geoip()->getLocation($ip);
        $ville = $localisatiobn->city;
        $pays = $localisatiobn->country;
        DB::table('logs')->insert([
            'user_id' => $request->user()->id,
            'action' => 'Deconnection Reussi',
            'ip' => $ip,
            'pays' => $pays,
            'ville' => $ville,
            'navigateur' => $request->header('User-Agent'),
            'created_at' => now(),
        ]);
        Session::flush();
        return redirect()->route('HOMES_web_index');


    }
}
