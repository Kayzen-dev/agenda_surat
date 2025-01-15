<?php
namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratMasukExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    public function query()
    {
        // Mengambil data surat masuk
        return SuratMasuk::query();
    }

    public function headings(): array
    {
        // Header Excel disesuaikan dengan tabel surat_masuk
        return [
            'NO',             // Kolom Nomor
            'ID',
            'Type Surat',
            'Kategori Surat',
            'Tanggal Terima Surat',
            'No Agenda',
            'Nomor Surat',
            'Tanggal Surat',
            'Asal Surat/Pengirim',
            'Perihal/Isi Surat',
            'Isi Disposisi',
            'Keterangan',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }

    public function map($suratMasuk): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $suratMasuk->id,
            $suratMasuk->type_surat,
            $suratMasuk->kategori_surat,
            $suratMasuk->tanggal_terima_surat,
            $suratMasuk->no_agenda,
            $suratMasuk->nomor_surat,
            $suratMasuk->tanggal_surat,
            $suratMasuk->asal_surat_pengirim,
            $suratMasuk->perihal_isi_surat,
            $suratMasuk->isi_disposisi,
            $suratMasuk->keterangan,
            $suratMasuk->created_at,
            $suratMasuk->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:N1')->applyFromArray([
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
        $sheet->getStyle('A1:N' . $sheet->getHighestRow())
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
