<?php

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/', function(){
    return view('welcome');
})->middleware('userAkses')->name('home');



Route::get('/guest', function(){
    return view('guest');
})->middleware('guest')->name('guest.page');


Route::middleware(['auth','verified','checkUser','session_timeout'])->group(function(){

    Route::get('/upload-surat', function (Request $request){
            // Validasi file PDF dan persentase
            $request->validate([
                'file_surat' => 'required|mimes:pdf', // file harus PDF
            ], [
                'file_surat.required' => 'File file_surat harus di tambahkan!',
                'file_surat.mimes' => 'File harus berupa PDF!',
            ]);
        
            // Mendapatkan file dari request
            $file = $request->file('file_surat');
        
            // Tentukan nama file dan path penyimpanan berdasarkan persentase
        
            // Hapus file_surat lama jika ada
            if (Storage::disk('public')->exists($file->extension())) {
                Storage::disk('public')->delete($file->extension()); // Hapus file lama
                Storage::disk('public')->put($file->extension(), file_get_contents($file));
    
                return back()->with('success', "File surat berhasil di Update!");
            }
        
            // Simpan file baru ke storage/app/public/file_surat
            Storage::disk('public')->put($file->extension(), file_get_contents($file));
        
            // Jika sukses, kembalikan respon atau redirect ke halaman lain
            return back()->with('success', "File Surat berhasil diunggah!");
        })->name('upload-file-surat');


    Route::get('/admin', function () {
        return view('admin.index');
    })->middleware('role:admin')->name('admin');


    
    Route::get('/sekretariat', function () {
        return view('sekre.index');
    })->middleware('role:sekretariat')->name('sekretariat');


    Route::get('/kearsipan', function () {
        return view('kearsipan.index');
    })->middleware('role:kearsipan')->name('kearsipan');


    Route::get('/layanan', function () {
        return view('layanan.index');
    })->middleware('role:layanan')->name('layanan');

    Route::get('/pengembangan', function () {
        return view('pengembangan.index');
    })->middleware('role:pengembangan')->name('pengembangan');






    Route::prefix('admin')->middleware('role:admin')->group(function () {

        

         Route::get('/export-users', function () {

            $filePath = '/tmp/users.xlsx'; 
            Excel::store(new UsersExport, $filePath);

            return response()->download($filePath)->deleteFileAfterSend();
            return Excel::download(new UsersExport(), 'users.xlsx');
        })->name('export.user');

        Route::get('/users', \App\Livewire\User\AdminCrudUser::class)->name('admin.users.index');
        
        Route::get('/logout/{id}/{route}', function ($id, $route) {
            $user = \App\Models\User::findOrFail($id);
            if ($user->hasRole('admin')) {
                $user->status_login = false;
                $user->save();
                Auth::logout();
            }
            $user->status_login = false;
            $user->save();
            return redirect('/admin/' . $route)->with('logout','Berhasil Log out '.$user->name);
        })->name('logout');


                Route::get('/export-users-pdf', function() {

                    $users = App\Models\User::query()->with('roles')->get();
        
                // Kirim data ke view
                $pdf = Pdf::loadView('Pdf.users', compact('users'));
        
                // Unduh file PDF
                return $pdf->download('users_agenda_surat.pdf');
             })->name('export-users-pdf');


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


    Route::get('/surat-keluar/{kategori_surat}/{tanggal_surat}', function ($kategori_surat,$tanggal_surat) {
        
        if (Auth::check()) {
            return SuratKeluar::where('bidang_surat', 'none')->where('kategori_surat', $kategori_surat)->where('tanggal_surat', $tanggal_surat)->get(['no', 'tanggal_surat','nomor_surat','kategori_surat'])->toArray();
        }else{
            return abort('404');
        }

    })->name('surat_keluar');


    // Route untuk ekspor Surat Masuk berdasarkan bidang
    Route::get('/export-surat-masuk/{bidang_surat}', function ($bidang_surat) {
        return Excel::download(new \App\Exports\SuratMasukExportBidangSurat($bidang_surat), 'surat_masuk_' . $bidang_surat . '.xlsx');
    })->name('export.surat.masuk');

    // Route untuk ekspor Surat Keluar berdasarkan bidang_surat
    Route::get('/export-surat-keluar/{bidang_surat}/{kategori_surat}', function ($bidang_surat,$kategori_surat) {
        return Excel::download(new \App\Exports\SuratKeluarExportBidangSurat($bidang_surat,$kategori_surat), 'surat_keluar_' . $bidang_surat . '.xlsx');
    })->name('export.surat.keluar');


    Route::get('/export-surat-keluar-pdf/{kategori_surat}/{tipe_surat}', function($kategori_surat) {
        $suratKeluar = SuratKeluar::where('kategori_surat', $kategori_surat)
            ->get();

        // Kirim data ke view
        $pdf = Pdf::loadView('Pdf.surat_keluar', compact('suratKeluar','kategori_surat'));

        // Unduh file PDF
        return $pdf->download('surat_keluar_'.$kategori_surat.'.pdf');
    })->name('export-surat-keluar-pdf');

    Route::get('/export-surat-masuk-pdf/{bidang_surat}', function($bidang_surat) {


        $suratMasuk = SuratMasuk::where('bidang_surat', $bidang_surat)
        ->get();

        // Kirim data ke view
        $pdf = Pdf::loadView('Pdf.surat_masuk', compact('suratMasuk','bidang_surat'));

        // Unduh file PDF
        return $pdf->download('surat_masuk_'.$bidang_surat.'.pdf');
               
    })->name('export-surat-masuk-pdf');











    Route::view('profile', 'profile')->name('profile');

});





require __DIR__.'/auth.php';
