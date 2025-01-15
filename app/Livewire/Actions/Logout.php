<?php

namespace App\Livewire\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $user->status_login = false;
            $user->save();
        }

        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
    }
}
