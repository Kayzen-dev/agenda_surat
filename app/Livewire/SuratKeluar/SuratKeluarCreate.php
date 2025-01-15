<?php

namespace App\Livewire\SuratKeluar;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\SuratKeluarForm;
use App\Livewire\SuratKeluar\SuratKeluarTable;

class SuratKeluarCreate extends Component
{
    public SuratKeluarForm $form;
    public $modalSuratKeluarCreate = false;

    public $bidang_surat;
    public $hideButton = true;



    public function mount()
    {

        
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




    public function save()
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->form->bidang_surat = $roles['0'];
            $this->bidang_surat = $roles['0'];
        }

        // dd($this->form);
        $this->validate();
        $simpan = $this->form->store();
        is_null($simpan)
            ? $this->dispatch('notify', title: 'fail', message: 'Data gagal disimpan')
            : $this->dispatch('notify', title: 'success', message: 'Data berhasil disimpan');
        $this->form->reset();
        $this->dispatch('dispatch-surat-keluar-create-save')->to(SuratKeluarTable::class);
        $this->modalSuratKeluarCreate = false;
        $this->bidang_surat = $roles['0'];

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
