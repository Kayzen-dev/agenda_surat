<?php

namespace App\Livewire\SuratKeluar;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Forms\SuratKeluarForm;
use App\Livewire\SuratKeluar\SuratKeluarTable;


class SuratKeluarCreate extends Component
{
    public SuratKeluarForm $form;
    public $modalSuratKeluarCreate = false;

    public $bidang_surat;
    public $hideButton = true;
    public $kategori_surat;
    public $kategori_surat_pdf;




    public function mount()
    {
        $this->form->tanggal_surat = now()->toDateString();
        $this->form->tahun = 2025;
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->form->bidang_surat = $roles['0'];
            $this->bidang_surat = $roles['0'];
        }

        $url = url()->current();
        $segments = explode('/', parse_url($url, PHP_URL_PATH));

        $segment1 = $segments[1] ?? null;
        $segment2 = $segments[2] ?? null;

        // Logika untuk menyembunyikan tombol jika segment2 ada
        if ($segment1 === 'sekretariat' && $segment2 != null) {
            $this->hideButton = false;
            $this->bidang_surat = $segment2;
        } else {
            $this->hideButton = true;
        }

    }


    public function exportExcel(){
        // dd($this->kategori_surat);
        if($this->kategori_surat != "null"){
            return Excel::download(new \App\Exports\SuratKeluarExport($this->kategori_surat), 'surat_keluar' . $this->kategori_surat . '.xlsx');
        }else{
            return redirect()->back();
        }
       
    }

    public function exportPdf(){
        // dd($this->kategori_surat);
        if($this->kategori_surat_pdf != "null"){
            return redirect()->route('export-surat-keluar-pdf',['kategori_surat' => $this->kategori_surat_pdf]);
            // return Excel::download(new \App\Exports\SuratKeluarExport($this->kategori_surat), 'surat_keluar' . $this->kategori_surat . '.xlsx');
        }else{
            return redirect()->back();
        }
       
    }



    public function save()
    {

        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->form->bidang_surat = $roles['0'];
            $this->bidang_surat = $roles['0'];
        }


        // Carbon::setLocale('id'); 

        // $this->form->tanggal_surat = Carbon::parse($this->form->tanggal_surat)->translatedFormat('d F Y');

        // dd($this->form);
        $this->validate();
        $simpan = $this->form->createSuratKeluar($this->form->no,$this->form->kategori_surat);
        is_null($simpan)
            ? $this->dispatch('notify', title: 'fail', message: 'Data gagal disimpan')
            : $this->dispatch('notify', title: 'success', message: 'Data berhasil disimpan');
        $this->form->reset();
        $this->dispatch('dispatch-surat-keluar-create-save')->to(SuratKeluarTable::class);
        $this->modalSuratKeluarCreate = false;
        $this->bidang_surat = $roles['0'];
        $this->form->tahun = now()->year;
        $this->form->tanggal_surat = now()->toDateString();



    }

    public function render()
    {
        return view('livewire.surat-keluar.surat-keluar-create',
        [
            'hideButton' => $this->hideButton,
        ]
    );
    }



}
