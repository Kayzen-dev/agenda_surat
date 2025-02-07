<?php

namespace App\Livewire\SuratKeluar;

use Livewire\Component;
use App\Models\SuratKeluar;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\SuratKeluar\SuratKeluarTable;

class SuratKeluarDelete extends Component
{

    #[Locked]
    public $id;

    public $modalSuratKeluarDelete = false;

    #[Locked]
    public $nomor_surat;

    #[On('dispatch-surat-keluar-table-delete')]
    public function set_surat($id,$nomor_surat){
        $this->id = $id;
        $this->nomor_surat = $nomor_surat;
        $this->modalSuratKeluarDelete = true;
    }

    public function del() {
        $del = SuratKeluar::findOrfail($this->id);
        $del->update(
            [
            'bidang_surat' => 'none',
            'nomor_surat' => '-',
            'tujuan_surat' => '-',
            'perihal_isi_surat' => '-',
            'keterangan' => '-',
            'file_surat' => '-',
            ]
        );
        ($del)
        ? $this->dispatch('notify', title: 'success',message: 'data berhasil dihapus')
        : $this->dispatch('notify', title: 'fail', message: 'data gagal dihapus ');
        // $this->form->reset();

        $this->dispatch('dispatch-surat-keluar-delete-del')->to(SuratKeluarTable::class);
        $this->modalSuratKeluarDelete = false;
    }



    public function render()
    {
        return view('livewire.surat-keluar.surat-keluar-delete');
    }


}
