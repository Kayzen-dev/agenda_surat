<?php

use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;



new #[Layout('layouts.login')] class extends Component
{
    public LoginForm $form;


    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        $this->validate();

        $this->form->authenticate();
        $user = User::find(Auth::id());

        if (Auth::check() && $user->status_login) {
            Auth::logout();
            return redirect()->route('login')->with('error_message', 'Akun sedang digunakan');
        }

        if (Auth::check()) {
            $user = User::find(Auth::id());
            $user->status_login = true;
            $user->save();
        }

        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin')->with('success', 'Log in Berhasil');
        }

        if (Auth::user()->hasRole('sekretariat')) {
            return redirect()->route('sekretariat')->with('success', 'Log in Berhasil');
        }

        if (Auth::user()->hasRole('layanan')) {
            return redirect()->route('layanan')->with('success', 'Log in Berhasil');
        }

        if (Auth::user()->hasRole('pengembangan')) {
            return redirect()->route('pengembangan')->with('success', 'Log in Berhasil');
        }

        if (Auth::user()->hasRole('kearsipan')) {
            return redirect()->route('kearsipan')->with('success', 'Log in Berhasil');
        }


        Session::regenerate();

    }
}; ?>


<div>



    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


  
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="px-6 py-4">

                @php
                    // dd(session()->all());
                @endphp

                <div class="flex justify-center mx-auto">
                    <img class="w-auto h-7 sm:h-8" src="{{ asset('images/logo_Dis.png') }}" style="width: 110px !important; height: 110px !important;" alt="Logo">
                </div>
    
                <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">Selamat Datang</h3>
                <p class="mt-1 text-center text-gray-500 dark:text-gray-400">Login untuk Masuk ke aplikasi</p>
                    @if (session('error_message'))
                    <div class="text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error_message') }}
                    </div>
                @endif
            
                @if(session('message'))
                    <div class="text-yellow-500 px-4 py-3 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif
    
                <form wire:submit="login">
                    <div class="w-full mt-4">
                        <input wire:model="form.id_user" id="id_user"  name="id_user" required autofocus class="block w-full px-4 py-2 mt-2 dark:text-gray-100 placeholder-gray-500 bg-white border rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="text" placeholder="Username atau Email" aria-label="Username atau Email" />
                        <x-input-error :messages="$errors->get('form.id_user')" class="mt-2" />
                    </div>
                    <div class="w-full mt-4 relative">
                        <input 
                            wire:model="form.password" 
                            autocomplete="current-password" 
                            id="password" 
                            class="block w-full px-4 py-2 pr-10 mt-2 dark:text-gray-100 placeholder-gray-500 bg-white border rounded-lg dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" 
                            type="password" 
                            placeholder="Password" 
                            aria-label="Password" 
                        />
                        <span 
                            id="toggle-password" 
                            class="absolute inset-y-0 right-3 flex items-center cursor-pointer dark:text-white"
                        >
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </span>
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />

                    </div>
                    
                    
                    <div class="flex items-center justify-between mt-4">
                        @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Lupa Password?') }}
                        </a>
                        @endif
    
                        {{-- <button class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-500 rounded-lg hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                            Sign In
                        </button> --}}
                        <x-primary-button class="ms-3">
                            <span  wire:loading.class="loading loading-spinner loading-md" ></span>
            
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>

            <div class="flex items-center justify-center py-4 text-center bg-gray-50 dark:bg-slate-600">
                <span class="text-sm text-gray-600 dark:text-gray-200">Kembali?</span>
        
                <a href="/" class="mx-2 text-sm font-bold text-blue-500 dark:text-blue-400 hover:underline">Beranda</a>
            </div>



        </div>
    </div>
    


    <script>
        // Mengubah tipe input password ketika ikon diklik
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
    
        togglePassword.addEventListener('click', function() {
            // Toggle password visibility
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
    
            // Ubah ikon berdasarkan kondisi
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script> 


</div>
