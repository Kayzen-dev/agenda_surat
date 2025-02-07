<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);




        $kategoriSuratList = [
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
            'Piagam'
        ];
        
        Carbon::setLocale('id');

        // Mendapatkan tanggal hari ini
        $tanggalSurat = Carbon::now()->translatedFormat('d F Y');    // format untuk database (YYYY-MM-DD)
        // Loop untuk setiap kategori surat
        foreach ($kategoriSuratList as $kategoriSurat) {
            // Cari nomor urut terakhir yang sudah ada untuk kategori ini pada hari sebelumnya
            $lastSurat = DB::table('surat_keluar')
                ->where('kategori_surat', $kategoriSurat)
                ->orderBy('no', 'desc')  // Mengambil nomor urut terbesar
                ->first();

            // Tentukan nomor urut mulai, jika tidak ada data sebelumnya maka mulai dari 1
            $startNo = $lastSurat ? $lastSurat->no + 1 : 1;

            // Tambahkan 6 data surat untuk kategori ini
            for ($i = $startNo; $i < $startNo + 6; $i++) {
                DB::table('surat_keluar')->insert([
                    'no' => $i,
                    'bidang_surat' => 'none', // bidang surat default
                    'kategori_surat' => $kategoriSurat, // kategori surat
                    'nomor_surat' => '-', // nomor surat sesuai contoh
                    'tanggal_surat' => $tanggalSurat, // tanggal surat sesuai hari ini
                    'tujuan_surat' => '-', // tujuan surat sesuai contoh
                    'perihal_isi_surat' => '-', // perihal isi surat sesuai contoh
                    'keterangan' => '-', // keterangan sesuai contoh
                    'created_at' => Carbon::now(), // waktu pembuatan data
                    'updated_at' => Carbon::now(), // waktu pembaruan data
                ]);
            }


        }
    
    }
}
