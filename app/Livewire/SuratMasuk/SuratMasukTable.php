<?php

namespace App\Livewire\SuratMasuk;

use App\Models\User;
use Livewire\Component;
use App\Models\SuratMasuk;
use App\Traits\WithSorting;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\SuratMasukForm;
use Illuminate\Support\Facades\Request;

class SuratMasukTable extends Component
{
    use WithPagination, WithSorting;

    public SuratMasukForm $form;

    public $paginate = 5; // Jumlah data per halaman
    public $sortBy = 'surat_masuk.id'; // Kolom default untuk pengurutan
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
    #[On('dispatch-surat-masuk-create-save')]
    #[On('dispatch-surat-masuk-update-edit')]
    #[On('dispatch-surat-masuk-delete-del')]
    public function render()
    {
        
        return view('livewire.surat-masuk.surat-masuk-table', [
            'data' => SuratMasuk::where('id', 'like', '%' . $this->form->id . '%')
                ->where('kategori_surat', 'like', '%' . $this->form->kategori_surat . '%')
                ->where('bidang_surat', 'like', '%' . $this->form->bidang_surat . '%')
                ->where('tanggal_terima_surat', 'like', '%' . $this->form->tanggal_terima_surat . '%')
                ->where('no_agenda', 'like', '%' . $this->form->no_agenda . '%')
                ->where('nomor_surat', 'like', '%' . $this->form->nomor_surat . '%')
                ->where('asal_surat_pengirim', 'like', '%' . $this->form->asal_surat_pengirim . '%')
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->paginate),
        ]);


    }


}
