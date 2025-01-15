<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
                $user = User::find(Auth::id());
                if($user->status_login == false){
                    return redirect()->route('login')->with('error_message', 'Anda Dikeluarkan Dari sesi');
                }
            

        }


        return $next($request);
    }
}
