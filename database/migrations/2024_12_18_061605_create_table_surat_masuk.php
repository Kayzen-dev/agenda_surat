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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->enum('bidang_surat', ['kearsipan', 'sekretariat','layanan','pengembangan']);
            $table->enum('kategori_surat', [
                "Surat Perintah",
                "Disposisi",
                "Instruksi",
                "Surat Edaran",
                "Surat Kuasa",
                "Berita Acara",
                "Surat Keterangan",
                "Surat dinas",
                "Pengumuman",
                "Surat Pernyataan Melaksanakan Tugas",
                "Surat Panggilan",
                "Surat Izin",
                "Lembaran Daerah",
                "Berita Daerah",
                "Rekomendasi",
                "Radiogram",
                "Surat Tanda Tamat Pendidikan dan Pelatihan",
                "Sertifikat",
                "Piagam",
                "Surat Perjanjian"
            ]);
            $table->date('tanggal_terima_surat');
            $table->string('no_agenda');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('asal_surat_pengirim');
            $table->string('perihal_isi_surat');
            $table->string('isi_disposisi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
