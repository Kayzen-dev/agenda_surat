<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class userAkses
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


            if ($user->hasRole('admin')) {
                return redirect()->route('admin');
            } elseif ($user->hasRole('sekretariat')) {
                return redirect()->route('sekretariat');
            } elseif ($user->hasRole('kearsipan')) {
                return redirect()->route('kearsipan');
            } elseif ($user->hasRole('layanan')) {
                return redirect()->route('layanan');
            } elseif ($user->hasRole('pengembangan')) {
                return redirect()->route('pengembangan');
            }else{
                return $next($request);
            }   
        }else{
            return $next($request);
        } 
        


    }
}
