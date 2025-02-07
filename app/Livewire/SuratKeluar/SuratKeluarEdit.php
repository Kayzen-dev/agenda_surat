<?php

namespace App\Livewire\SuratKeluar;

use Livewire\Component;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Livewire\Attributes\On;
use App\Livewire\Forms\SuratKeluarForm;
use App\Livewire\SuratKeluar\SuratKeluarTable;

class SuratKeluarEdit extends Component
{

    public $hideButton = true;
    public $modalSuratKeluarEdit = false;
    public $modelSuratMasuk;
    public SuratKeluarForm $form;



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



    #[On('dispatch-surat-keluar-table-edit')]
    public function set_surat(SuratKeluar $id){

        $this->form->setSuratKeluar($id);
        $this->modalSuratKeluarEdit = true;
    }


    public function edit() {
        dd($this->form);
        $update = $this->form->update($this->form->id);

        is_null($update)
        ? $this->dispatch('notify', title: 'fail', message: 'data gagal diUpdate')
        : $this->dispatch('notify', title: 'success',message: 'data berhasil diUpdate');
        $this->form->reset();
        $this->dispatch('dispatch-surat-keluar-update-edit')->to(SuratKeluarTable::class);
        $this->modalSuratKeluarEdit = false;


    }



    public function render()
    {
        return view('livewire.surat-keluar.surat-keluar-edit', [
            'hideButton' => $this->hideButton,
        ]);
    }
}
