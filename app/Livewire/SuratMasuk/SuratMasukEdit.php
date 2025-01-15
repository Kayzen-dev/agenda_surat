<?php

namespace App\Livewire\SuratMasuk;

use Livewire\Component;
use App\Models\SuratMasuk;
use Livewire\Attributes\On;
use App\Livewire\Forms\SuratMasukForm;
use App\Livewire\SuratMasuk\SuratMasukTable;

class SuratMasukEdit extends Component
{
    public $modalSuratMasukEdit = false;

    public $hideButton = true;

    public SuratMasukForm $form;

    public function mount(){
                // Ambil URL saat ini
        $url = url()->current();
        $segments = explode('/', parse_url($url, PHP_URL_PATH));

        $segment1 = $segments[1] ?? null;
        $segment2 = $segments[2] ?? null;

        // Logika untuk menyembunyikan tombol jika segment2 ada
        if ($segment1 === 'sekretariat' && $segment2 != null) {
            $this->hideButton = false;
        } else {
            $this->hideButton = true;
        }

    }

    #[On('dispatch-surat-masuk-table-edit')]
    public function set_surat(SuratMasuk $id)
    {
        $this->form->setSuratMasuk($id);


        $this->modalSuratMasukEdit = true;
    }

    public function edit()
    {
        $update = $this->form->update($this->form->id);

        is_null($update)
            ? $this->dispatch('notify', title: 'fail', message: 'Data gagal diupdate')
            : $this->dispatch('notify', title: 'success', message: 'Data berhasil diupdate');
        
        $this->form->reset();
        $this->dispatch('dispatch-surat-masuk-update-edit')->to(SuratMasukTable::class);
        $this->modalSuratMasukEdit = false;
    }

    public function render()
    {
        return view('livewire.surat-masuk.surat-masuk-edit', [
            'hideButton' => $this->hideButton,
        ]);
    }
}
