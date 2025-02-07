<?php

namespace App\Livewire\SuratKeluar;

use App\Models\User;
use Livewire\Component;
use App\Models\SuratKeluar;
use App\Traits\WithSorting;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\SuratKeluarForm;
use Illuminate\Support\Facades\Request;

class SuratKeluarTable extends Component
{
    use WithPagination, WithSorting;

    public SuratKeluarForm $form;


    public $paginate = 5; // Jumlah data per halaman
    public $sortBy = 'surat_keluar.id'; // Kolom default untuk pengurutan
    public $sortDirection = 'desc'; // Arah pengurutan default
    public $hideDeleteButton = false;


    public function mount(){
        $this->form->bidang_surat = $this->setBidangSurat();

        $segment1 = Request::segment(1);
        $segment2 = Request::segment(2);

        if ($segment1 === 'sekretariat' && $segment2 !== null) {
            $this->hideDeleteButton = true;
        }
    }




    public function downloadFile($id)
    {
        $surat = SuratKeluar::find($id);
        if ($surat && $surat->file_surat) {
            return response()->download(storage_path("app/public/{$surat->file_surat}"));
        }
    }



    public function setBidangSurat()
    {
        if (Auth::check()) {
            $auth = Auth::user()->id;
            $user = User::find($auth);
            $roles = $user->getRoleNames();
            if ($roles['0'] == 'sekretariat') {
                $routeSegment = Request::segment(2); 
                return $routeSegment ?: 'sekretariat';
            }else{
                return $roles[0];
            }
        }
    }

    // Realtime proses
    #[On('dispatch-surat-keluar-create-save')]
    #[On('dispatch-surat-keluar-update-edit')]
    #[On('dispatch-surat-keluar-delete-del')]
    public function render()
    {

        
        return view('livewire.surat-keluar.surat-keluar-table',[
            'data' => SuratKeluar::where('id', 'like', '%' . $this->form->id . '%')
                ->where('bidang_surat', $this->form->bidang_surat)
                ->where('tanggal_surat', 'like', '%' . $this->form->tanggal_surat . '%')
                ->where('nomor_surat', 'like', '%' . $this->form->nomor_surat . '%')
                ->where('tujuan_surat', 'like', '%' . $this->form->tujuan_surat . '%')
                ->where('perihal_isi_surat', 'like', '%' . $this->form->perihal_isi_surat . '%')
                ->where('keterangan', 'like', '%' . $this->form->keterangan . '%')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->paginate),
        ]);


    }


}
