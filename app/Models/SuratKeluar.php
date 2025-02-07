<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'bidang_surat',
        'kategori_surat',
        'nomor_surat',
        'tanggal_surat',
        'tujuan_surat',
        'perihal_isi_surat',
        'keterangan',
        'file_surat'
    ];


}
