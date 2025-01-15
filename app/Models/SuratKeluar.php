<?php

namespace App\Models;

use App\Models\SuratMasuk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'tanggal_kirim_surat',
        'nomor_surat',
        'tanggal_surat',
        'tujuan_surat',
        'perihal_isi_surat',
        'keterangan',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class,'id_surat_masuk');
    }
}
