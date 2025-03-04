<?php

namespace App\Livewire\SuratMasuk;

use Livewire\Component;
use App\Models\SuratMasuk;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Storage;
use App\Livewire\SuratMasuk\SuratMasukTable;

class SuratMasukDelete extends Component
{
    #[Locked]
    public $id;

    public $modalSuratMasukDelete = false;


    #[Locked]
    public $nomor_surat;

    #[On('dispatch-surat-masuk-table-delete')]
    public function set_surat($id,$nomor_surat){
        $this->id = $id;
        $this->nomor_surat = $nomor_surat;
        $this->modalSuratMasukDelete = true;
    }

    public function del() {
        $surat = SuratMasuk::find($this->id);
        if ($surat) {
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }
        }
        
        $del = SuratMasuk::destroy( $this->id );

        ($del)
        ? $this->dispatch('notify', title: 'success',message: 'data berhasil dihapus')
        : $this->dispatch('notify', title: 'fail', message: 'data gagal dihapus ');
        // $this->form->reset();
        $this->dispatch('dispatch-surat-masuk-delete-del')->to(SuratMasukTable::class);
        $this->modalSuratMasukDelete = false;
    }



    
    public function render()
    {
        return view('livewire.surat-masuk.surat-masuk-delete');
    }
}
