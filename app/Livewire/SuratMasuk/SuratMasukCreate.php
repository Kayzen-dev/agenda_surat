<?php

namespace App\Livewire\SuratMasuk;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\SuratMasukForm;
use App\Livewire\SuratMasuk\SuratMasukTable;

class SuratMasukCreate extends Component
{
    public $hideButton = true;
    
    public SuratMasukForm $form;
    public $modalSuratMasukCreate = false;

    public $bidang_surat;
    

    public function mount()
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->form->bidang_surat = $roles['0'];
            $this->bidang_surat = $roles['0'];
        }

        $this->form->tanggal_terima_surat = now()->toDateString();

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


    public function save() {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->form->bidang_surat = $roles['0'];
        }

        // dd($this->form);
        $this->validate();
        $simpan = $this->form->store();
        is_null($simpan)
        ? $this->dispatch('notify', title: 'fail', message: 'data gagal disimpan')
        : $this->dispatch('notify', title: 'success', message: 'data berhasil disimpan');
        $this->form->reset();
        $this->dispatch('dispatch-surat-masuk-create-save')->to(SuratMasukTable::class);
        $this->modalSuratMasukCreate = false;
        $this->form->tanggal_terima_surat = now()->toDateString();
        $this->bidang_surat = $roles['0'];

    }

    public function render()
    {
        return view('livewire.surat-masuk.surat-masuk-create',
        [
            'hideButton' => $this->hideButton,
        ]
    );
    }
}
