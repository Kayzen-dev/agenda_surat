<?php

use Carbon\Carbon;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;


Route::get('/', function(){
    return view('welcome');
})->middleware('userAkses')->name('home');



Route::get('/guest', function(){
    return view('guest');
})->middleware('guest')->name('guest.page');


Route::middleware(['auth','verified','checkUser','session_timeout'])->group(function(){

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


            Route::post('/buat-data-surat-keluar-bulan', function (Request $request) {
                // Ambil bulan dan tahun yang dipilih dari form
                $bulan = $request->input('bulan');
                $tahun = now()->year;
            
                $kategoriSuratList = [
                    'Surat Perintah', 'Surat Tugas', 'Surat Perjalanan Dinas', 'Disposisi',
                    'Nota Dinas', 'Surat Dinas', 'Surat Kuasa', 'Berita Acara', 'Surat Keterangan',
                    'Telaahan Staf', 'Pengumuman', 'Surat Pernyataan Melaksanakan Tugas', 'Surat Panggilan',
                    'Surat Izin', 'Surat Perjanjian', 'Rekomendasi', 'Sertifikat', 'Piagam'
                ];
            
                Carbon::setLocale('id');
                $bulanIni = Carbon::create($tahun, $bulan)->translatedFormat('F Y'); // Format bulan dan tahun yang dipilih
                $hariDalamBulan = Carbon::create($tahun, $bulan)->daysInMonth; // Jumlah hari dalam bulan yang dipilih
            
                $semuaKategoriSudahPenuh = true; // Flag cek apakah semua kategori sudah penuh
            
                for ($tanggal = 1; $tanggal <= $hariDalamBulan; $tanggal++) {
                    $tanggalSurat = sprintf('%02d', $tanggal) . " " . $bulanIni; // Format: "01 Februari 2025"
            
                    foreach ($kategoriSuratList as $kategoriSurat) {
                        // Cek jumlah surat yang sudah ada untuk tanggal ini
                        $countToday = DB::table('surat_keluar')
                            ->where('kategori_surat', $kategoriSurat)
                            ->where('tanggal_surat', $tanggalSurat)
                            ->count();
            
                        if ($countToday >= 6) {
                            continue;
                        }
            
                        $semuaKategoriSudahPenuh = false; // Jika ada yang belum 6, maka masih bisa ditambah
            
                        // Cari nomor urut terakhir
                        $lastSurat = DB::table('surat_keluar')
                            ->where('kategori_surat', $kategoriSurat)
                            ->orderBy('no', 'desc')
                            ->first();
                    
                        $startNo = $lastSurat ? $lastSurat->no + 1 : 1;
                        $sisaTambah = 6 - $countToday;
            
                        for ($i = 0; $i < $sisaTambah; $i++) {
                            DB::table('surat_keluar')->insert([
                                'no' => $startNo + $i,
                                'bidang_surat' => 'none',
                                'kategori_surat' => $kategoriSurat,
                                'nomor_surat' => '-',
                                'tanggal_surat' => $tanggalSurat,
                                'tujuan_surat' => '-',
                                'perihal_isi_surat' => '-',
                                'keterangan' => '-',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }
                }
            
                if ($semuaKategoriSudahPenuh) {
                    return redirect()->route('sekretariat')->with('success','Data surat keluar sudah dibuat untuk bulan ini');
                }
            
                return redirect()->route('sekretariat')->with('success','Surat berhasil dibuat untuk satu bulan penuh!');

            })->name('sekre.buat.surat.keluar');
            

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


    Route::get('/export-surat-keluar-pdf/{kategori_surat}', function($kategori_surat) {
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
