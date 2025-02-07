<?php
namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratKeluarExportBidangSurat implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $bidangSurat;
    private $kategoriSurat;
    private $rowNumber = 0;

    public function __construct($bidangSurat,$kategoriSurat)
    {
        $this->bidangSurat = $bidangSurat;
        $this->kategoriSurat = $kategoriSurat;
    }

    public function query()
    {
        return SuratKeluar::where('bidang_surat', $this->bidangSurat)->where('kategori_surat',$this->kategoriSurat);
    }

    public function headings(): array
    {
        return [
            'NO',
            'Tanggal Surat',
            'Nomor Surat',
            'Tujuan Surat',
            'Perihal/Isi Surat',
            'Keterangan',
            'Kategori Surat'
        ];
    }

    public function map($suratKeluar): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $suratKeluar->tanggal_surat,
            $suratKeluar->nomor_surat,
            $suratKeluar->tujuan_surat,
            $suratKeluar->perihal_isi_surat,
            $suratKeluar->keterangan,
            $suratKeluar->kategori_surat
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'],
            ],
        ]);

        $sheet->getStyle('A1:G' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
