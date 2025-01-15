<?php
namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratKeluarExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    public function query()
    {
        // Mengambil data surat keluar
        return SuratKeluar::query();
    }

    public function headings(): array
    {
        // Header Excel disesuaikan dengan tabel surat_keluar
        return [
            'NO',             // Kolom Nomor
            'ID',
            'Tanggal Kirim Surat',
            'Nomor Surat',
            'Tanggal Surat',
            'Tujuan Surat',
            'Perihal/Isi Surat',
            'Keterangan',
            'ID Surat Masuk',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }

    public function map($suratKeluar): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $suratKeluar->id,
            $suratKeluar->tanggal_kirim_surat,
            $suratKeluar->nomor_surat,
            $suratKeluar->tanggal_surat,
            $suratKeluar->tujuan_surat,
            $suratKeluar->perihal_isi_surat,
            $suratKeluar->keterangan,
            $suratKeluar->id_surat_masuk,
            $suratKeluar->created_at,
            $suratKeluar->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // Teks putih
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'], // Latar belakang biru
            ],
        ]);

        // Style border untuk seluruh data
        $sheet->getStyle('A1:K' . $sheet->getHighestRow())
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'], // Border hitam
                    ],
                ],
            ]);

        // Style untuk nomor (kolom pertama)
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
