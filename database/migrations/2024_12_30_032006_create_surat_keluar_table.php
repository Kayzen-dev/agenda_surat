<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('no');
            $table->enum('bidang_surat', ['kearsipan', 'sekretariat','layanan','pengembangan','none']);
            $table->enum('kategori_surat', [
                'Surat Perintah',
                'Surat Tugas',
                'Surat Perjalanan Dinas',
                'Disposisi',
                'Nota Dinas',
                'Surat Dinas',
                'Surat Kuasa',
                'Berita Acara',
                'Surat Keterangan',
                'Telaahan Staf',
                'Pengumuman',
                'Surat Pernyataan Melaksanakan Tugas',
                'Surat Panggilan',
                'Surat Izin',
                'Surat Perjanjian',
                'Rekomendasi',
                'Sertifikat',
                'Piagam',
            ]);
            $table->string('nomor_surat');
            $table->string('tanggal_surat');
            $table->string('tujuan_surat');
            $table->string('perihal_isi_surat');
            $table->string('keterangan');
            $table->string('file_surat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
