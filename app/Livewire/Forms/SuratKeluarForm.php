<?php

namespace App\Livewire\Forms;

use App\Models\SuratKeluar;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SuratKeluarForm extends Form
{
    public ?SuratKeluar $SuratKeluar = null;
    public $id;
    public $nomor_surat;
    public $file_surat;


     // Kode akses harus berupa karakter dari A sampai Z
     #[Validate('required', message: 'Kode akses wajib diisi')]
     public $kode_akses;
 
     // Kode klasifikasi harus berupa angka dengan beberapa titik
    #[Validate('required', message: 'Kode klasifikasi wajib diisi')]
    #[Validate('regex:/^\d{1,3}(\.\d+)*$/', message: 'Kode klasifikasi harus berupa angka dan sesuai dengan kode klasifikasi')]
    public $kode_klasifikasi;

 
     // Nama instansi harus berupa string
     #[Validate('required', message: 'Nama instansi wajib diisi')]
     #[Validate('string', message: 'Nama instansi harus berupa kata')]
     public $nama_instansi;
 
     // Tahun harus berupa integer
     #[Validate('required', message: 'Tahun wajib diisi')]
     #[Validate('integer', message: 'Tahun harus berupa angka')]
     public $tahun;
 
     // Validasi untuk nomor surat
     #[Validate('required', message: 'No Urut wajib dipilih')]
     #[Validate('integer', message: 'Nomor surat harus berupa angka')]
     public $no;
 



    #[Validate('required', message: 'Bidang surat wajib diisi')]
    #[Validate('in:kearsipan,sekretariat,layanan,pengembangan', message: 'Bidang surat tidak valid')]
    public $bidang_surat;

    #[Validate('required', message: 'Kategori surat wajib diisi')]
    public $kategori_surat;


    #[Validate('required', message: 'Tanggal surat wajib diisi')]
    public $tanggal_surat;

    #[Validate('required', message: 'Tujuan surat wajib diisi')]
    public $tujuan_surat;

    #[Validate('required', message: 'Perihal isi surat wajib diisi')]
    public $perihal_isi_surat;

    #[Validate('required', message: 'Keterangan wajib diisi')]
    public $keterangan;


    
    public function store()
    {
        $this->validate();

        return SuratKeluar::create([
            'bidang_surat' => $this->bidang_surat,
            'kategori_surat' => $this->kategori_surat,
            'no' => $this->no,
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'tujuan_surat' => $this->tujuan_surat,
            'perihal_isi_surat' => $this->perihal_isi_surat,
            'keterangan' => $this->keterangan,
        ]);

    }

     // Fungsi untuk membuat nomor surat dengan format: kode_akses/kode_klasifikasi/no/nama_instansi/tahun
     public function buatNomorSurat() {
        // Pastikan semua property sudah terisi sebelum membuat nomor surat
        if (!empty($this->kode_akses) && !empty($this->kode_klasifikasi) && !empty($this->no) && !empty($this->nama_instansi) && !empty($this->tahun)) {
            // Format nomor surat: kode_akses/kode_klasifikasi/no/nama_instansi/tahun
            return "{$this->kode_akses}/{$this->kode_klasifikasi}/{$this->no}/{$this->nama_instansi}/{$this->tahun}";
        } else {
            return "-";
        }
    }

    public function update($id)
    {
        $this->validate();

        $SuratKeluar = SuratKeluar::findOrFail($id);

        $SuratKeluar->update([
            'bidang_surat' => $this->bidang_surat,
            'kategori_surat' => $this->kategori_surat,
            'no' => $this->no,
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'tujuan_surat' => $this->tujuan_surat,
            'perihal_isi_surat' => $this->perihal_isi_surat,
            'keterangan' => $this->keterangan,
        ]);

        return $SuratKeluar;
    }


    public function createSuratKeluar($no,$kategori_surat)
    {
        $this->validate();

        $SuratKeluar = SuratKeluar::where('no', $no)->where('kategori_surat',$kategori_surat);

        $SuratKeluar->update([
            'bidang_surat' => $this->bidang_surat,
            'kategori_surat' => $this->kategori_surat,
            'no' => $this->no,
            'nomor_surat' => $this->buatNomorSurat(),
            'tujuan_surat' => $this->tujuan_surat,
            'perihal_isi_surat' => $this->perihal_isi_surat,
            'keterangan' => $this->keterangan,
        ]);

        return $SuratKeluar;
    }

    public function setSuratKeluar(SuratKeluar $SuratKeluar)
    {
        $this->SuratKeluar = $SuratKeluar;
        $this->id = $SuratKeluar->id;
        
        $this->bidang_surat = $SuratKeluar->bidang_surat;
        $this->kategori_surat = $SuratKeluar->kategori_surat;
        $this->no = $SuratKeluar->no;
        $this->nomor_surat = $SuratKeluar->nomor_surat;
        $this->tanggal_surat = $SuratKeluar->tanggal_surat;
        $this->tujuan_surat = $SuratKeluar->tujuan_surat;
        $this->perihal_isi_surat = $SuratKeluar->perihal_isi_surat;
        $this->keterangan = $SuratKeluar->keterangan;
    }




}
