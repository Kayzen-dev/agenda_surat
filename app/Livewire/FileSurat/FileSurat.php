<?php

namespace App\Livewire\FileSurat;

use App\Models\User;
use Livewire\Component;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class FileSurat extends Component
{

    use  WithFileUploads;

    #[Locked]
    public $id;

    public $showModal = false;
    public $file;
    public $selectedSuratId;
    public $bidangSurat;
    public $tipeSurat;

    #[On('dispatch-surat-keluar-table-upload')]
    public function set_file($id,$tipeSurat){
        $this->id = $id;
        $this->tipeSurat = $tipeSurat;
        $this->showModal = true;
    }


    public function uploadFile()
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->bidangSurat = $roles['0'];
        }
        
        $this->validate([
            'file' => 'required|mimes:pdf', // Maksimal 2MB
        ],
        [
            'file.required' => 'file surat wajid disi',
            'file.mimes' => 'file surat harus pdf'
        ]
    
    );

        
    
        $surat = $this->tipeSurat == 'surat-keluar' ? SuratKeluar::find($this->id) : SuratMasuk::find($this->id);

        if ($surat) {
            // Ambil nama asli file
            $originalName = $this->file->getClientOriginalName();
            
            // Tambahkan tanggal di depan nama file
            $timestamp = now()->format('Ymd_His'); // Format: TahunBulanTanggal_JamMenitDetik
            $newFileName = $this->bidangSurat . '_' . $originalName;
    
            // Simpan file dengan nama baru
            $folder = $this->tipeSurat == 'surat-keluar' ? 'surat_keluar' : 'surat_masuk';
            $path = $this->file->storeAs($folder, $newFileName, 'public');
            
            // Simpan path ke database
            $surat->update(['file_surat' => $path]);
    
            // Notifikasi sukses
            $this->dispatch('notify', title: 'success', message: 'File berhasil diupload');
            $this->showModal = false;
        } else {
            // Notifikasi gagal
            $this->dispatch('notify', title: 'fail', message: 'File gagal diupload');
            $this->showModal = false;
        }
    }
    
    

    public function render()
    {
        return view('livewire..file-surat.file-surat');
    }

}
