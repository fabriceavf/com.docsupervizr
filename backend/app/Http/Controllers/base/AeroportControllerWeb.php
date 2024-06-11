<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use URL;


class AeroportControllerWeb extends Controller
{


    /**
     */
    public function __construct(Request $request)
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */


    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function rooter(Request $request, $token)
    {

//        $key = env('TOKEN_JWT_KEY');
//        $decoded = JWT::decode($token,new Key($key, 'HS256'));
//        dd($decoded);
//        $user=User::findOrFail($decoded->user_id);
//        Auth::login($user);
//        $url=\URL::signedRoute("$decoded->destinatio",$decoded->params ?? []);
//        dd($decoded,$url,Auth::id());
//        return redirect($url);
        try {
            $key = env('TOKEN_JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $data = json_decode(json_encode($decoded), true);
            $new = [];
            foreach ($data as $key => $don) {
                if ($key != 'user_id' && $key != 'destination') {
                    $new[$key] = $don;
                }
            }
            $user = User::findOrFail($decoded->user_id);
            Auth::login($user);
//            dd($decoded);

            $url = URL::signedRoute("$decoded->destination", $new);
//            dd($decoded,$url,Auth::id());
            return redirect($url);
        } catch (Exception $e) {
            echo 'Exception message ' . $e;
        }


    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function getRooter(Request $request)
    {
        $data = [
            'route' => 'web_index_Connections'
        ];

        dd(Auth::user()->visa($data));


    }


}



