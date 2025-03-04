<?php

namespace App\Livewire\FileSurat;

use App\Models\User;
use Livewire\Component;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileSuratUpdate extends Component
{
    use WithFileUploads;

    #[Locked]
    public $id;

    public $showModal = false;
    public $file;
    public $bidangSurat;
    public $tipeSurat;

    #[On('dispatch-surat-keluar-table-update')]
    public function set_file($id,$tipeSurat)
    {
        $this->tipeSurat = $tipeSurat;
        $this->id = $id;
        $this->showModal = true;
    }

    public function updateFile()
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $roles = $user->getRoleNames();  
            $this->bidangSurat = $roles[0] ?? 'none';
        }
        
        $this->validate([
            'file' => 'required|mimes:pdf',
        ]);
    
        $surat = $this->tipeSurat == 'surat-keluar' ? SuratKeluar::find($this->id) : SuratMasuk::find($this->id);
        
        if ($surat) {
            // Hapus file lama jika ada
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }
    
            // Simpan file baru
            $originalName = $this->file->getClientOriginalName();
            $newFileName = $this->bidangSurat . '_' . $originalName;

            $folder = $this->tipeSurat == 'surat-keluar' ? 'surat_keluar' : 'surat_masuk';
            $path = $this->file->storeAs($folder, $newFileName, 'public');
    
            // Perbarui path file di database
            $surat->update(['file_surat' => $path]);
    
            $this->dispatch('notify', title: 'success', message: 'File berhasil diperbarui');
            $this->showModal = false;
        } else {
            $this->dispatch('notify', title: 'fail', message: 'File gagal diperbarui');
            $this->showModal = false;
        }
    }
    
    public function render()
    {
        return view('livewire.file-surat.file-surat-update');
    }
}
