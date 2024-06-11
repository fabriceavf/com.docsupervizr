<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Throwable;


class AuthController extends Controller
{

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|',
            'c_password' => 'required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        if ($user->save()) {
            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
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
            DB::table('surveillances')->insert([
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

            $back = url()->previous();

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

        DB::table('surveillances')->insert([
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

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public
    function logout(Request $request)
    {
        $ip = $request->ip();
        try {

            $ip = $request->header('x-forwarded-for');
        } catch (Throwable $e) {
        }
        $localisatiobn = geoip()->getLocation($ip);
        $ville = $localisatiobn->city;
        $pays = $localisatiobn->country;
        DB::table('surveillances')->insert([
            'user_id' => $request->user()->id,
            'action' => 'Deconnection Reussi',
            'ip' => $ip,
            'pays' => $pays,
            'ville' => $ville,
            'navigateur' => $request->header('User-Agent'),
            'created_at' => now(),
        ]);


//        Auth::user()->token()->revoke();


        Session::flush();

        $url = URL::signedRoute('HOMES_web_index');
        $url = Str::replace('http://', 'https://', $url);

        return redirect()->to($url);


    }
}
