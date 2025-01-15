<?php
namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratKeluarExportBidangSurat implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $bidangSurat;
    private $rowNumber = 0;

    public function __construct($bidangSurat)
    {
        $this->bidangSurat = $bidangSurat;
    }

    public function query()
    {
        return SuratKeluar::with('suratMasuk') // Eager load relasi suratMasuk
            ->where('bidang_surat', $this->bidangSurat);
    }

    public function headings(): array
    {
        return [
            'NO',
            'ID',
            'Tanggal Kirim Surat',
            'Nomor Surat',
            'Tanggal Surat',
            'Tujuan Surat',
            'Perihal/Isi Surat',
            'Keterangan',
            'Kategori Surat', // Tambahkan kolom Kategori Surat
            'Surat Masuk', // Kolom Surat Masuk
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }

    public function map($suratKeluar): array
    {
        $this->rowNumber++;

        // Logika untuk kolom Surat Masuk
        $suratMasuk = $suratKeluar->suratMasuk
            ? $suratKeluar->suratMasuk->nomor_surat . ' - ' . $suratKeluar->suratMasuk->asal_surat_pengirim
            : 'Tidak ada surat masuk';

        return [
            $this->rowNumber,
            $suratKeluar->id,
            $suratKeluar->tanggal_kirim_surat,
            $suratKeluar->nomor_surat,
            $suratKeluar->tanggal_surat,
            $suratKeluar->tujuan_surat,
            $suratKeluar->perihal_isi_surat,
            $suratKeluar->keterangan,
            $suratKeluar->kategori_surat, // Tambahkan kategori surat
            $suratMasuk, // Kolom Surat Masuk
            $suratKeluar->created_at,
            $suratKeluar->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // Teks putih
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'], // Latar belakang biru
            ],
        ]);

        $sheet->getStyle('A1:L' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Border hitam
                ],
            ],
        ]);

        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
