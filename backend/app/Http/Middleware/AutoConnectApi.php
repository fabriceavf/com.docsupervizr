<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoConnectApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('auto_user_name') && $request->has('auto_user_password')) {
            $credentials = ['email' => $request->get('auto_user_name'), 'password' => $request->get('auto_user_password')];
            $credentials['deleted_at'] = null;

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $accesToken = $tokenResult->accessToken;
                $request->headers->set('Authorization', 'Bearer ' . $accesToken);
                return $next($request);
//                $request->r

            }
        } else {
        }
        return $next($request);
    }
}
