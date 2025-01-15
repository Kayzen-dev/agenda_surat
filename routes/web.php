<?php

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');


Route::get('/guest', function(){
    return view('guest');
})->middleware('guest')->name('guest.page');


Route::middleware(['auth','verified','chek_role'])->group(function(){

    
    Route::get('/home', function(){
        if (Auth::check()) {
            $user = \App\Models\User::find(Auth::id());
            $user->status_login = false;
            $user->save();
        }

        Auth::logout();
        return view('welcome');
    })->name('dashboard');



    Route::get('/admin', function () {
        return view('admin.index');
    })->middleware('role:admin')->name('admin');


    
    Route::get('/sekretariat', function () {
        return view('sekre.index');
    })->middleware('role:sekretariat')->name('sekretariat');





    Route::prefix('admin')->middleware('role:admin')->group(function () {
        
        Route::get('/export-users', function () {
            return Excel::download(new UsersExport(), 'users.xlsx');
        })->name('export.user');


        Route::get('/export-users-pdf', function() {

                $users = \App\Models\User::with('roles')->get();

                // Kirim data ke view
                $pdf = Pdf::loadView('Pdf.users', compact('users'));

                // Unduh file PDF
                return $pdf->download('agenda-surat-users.pdf');
            
        })->name('export-user-pdf');

        Route::get('/users', \App\Livewire\User\AdminCrudUser::class)->name('admin.users.index');
        
        Route::get('/logout/{id}/{route}', function ($id, $route) {
            $user = \App\Models\User::findOrFail($id);
            $user->status_login = false;
            $user->save();
            return redirect('/admin/' . $route)->with('logout','Berhasil Log out '.$user->name);
        })->name('logout');

    });
    
    
    Route::prefix('sekretariat')->middleware('role:sekretariat')->group(function () {

        Route::get('/kearsipan', function () {
            return view('sekre.kearsipan');
        })->name('sekre.kearsipan.index');

        Route::get('/pengembangan', function () {
            return view('sekre.pengembangan');
        })->name('sekre.pengembangan.index');

        Route::get('/layanan', function () {
            return view('sekre.layanan');
        })->name('sekre.layanan.index');


    });




    Route::get('/surat-masuk', function () {
        
        if (Auth::check()) {
            $user =  \App\Models\User::find(Auth::id());
            $roles = $user->getRoleNames();  
            return SuratMasuk::where('bidang_surat', $roles['0'])
            ->whereDoesntHave('suratKeluar')
            ->get(['id', 'nomor_surat', 'asal_surat_pengirim'])->toArray();

        }else{
            return abort('404');
        }

    })->name('surat_masuk');


    // Route::get('/export-surat-masuk', function () {
    //     return Excel::download(new \App\Exports\SuratMasukExport(), 'surat-masuk.xlsx');
    // })->name('export.surat.masuk');



    // Route::get('/export-surat-keluar', function () {
    //     return Excel::download(new \App\Exports\SuratKeluarExport(), 'surat-keluar.xlsx');
    // })->name('export.surat.keluar');


    // Route untuk ekspor Surat Masuk berdasarkan bidang
    Route::get('/export-surat-masuk/{bidang_surat}', function ($bidang_surat) {
        return Excel::download(new \App\Exports\SuratMasukExportBidangSurat($bidang_surat), 'surat_masuk_' . $bidang_surat . '.xlsx');
    })->name('export.surat.masuk');

    // Route untuk ekspor Surat Keluar berdasarkan bidang_surat
    Route::get('/export-surat-keluar/{bidang_surat}', function ($bidang_surat) {
        return Excel::download(new \App\Exports\SuratKeluarExportBidangSurat($bidang_surat), 'surat_keluar_' . $bidang_surat . '.xlsx');
    })->name('export.surat.keluar');


    Route::get('/export-surat-pdf/{bidang_surat}/{tipe_surat}', function($bidang_surat,$tipe_surat) {

                if ($tipe_surat == 'surat-keluar') {
                    $suratKeluar = SuratKeluar::with('suratMasuk') 
                        ->where('bidang_surat', $bidang_surat)
                        ->get();
            
                    // Kirim data ke view
                    $pdf = Pdf::loadView('Pdf.surat_keluar', compact('suratKeluar','bidang_surat'));
            
                    // Unduh file PDF
                    return $pdf->download('surat_keluar_'.$bidang_surat.'.pdf');
                }else {
                    $suratMasuk = SuratMasuk::with('suratKeluar') 
                        ->where('bidang_surat', $bidang_surat)
                        ->get();
            
                    // Kirim data ke view
                    $pdf = Pdf::loadView('Pdf.surat_masuk', compact('suratMasuk','bidang_surat'));
            
                    // Unduh file PDF
                    return $pdf->download('surat_masuk_'.$bidang_surat.'.pdf');
                }
               
    })->name('export-surat-pdf');











    Route::view('profile', 'profile')->name('profile');

});





require __DIR__.'/auth.php';
