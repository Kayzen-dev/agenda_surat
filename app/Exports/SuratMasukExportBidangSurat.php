<?php
namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratMasukExportBidangSurat implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $bidangSurat;
    private $rowNumber = 0;

    public function __construct($bidangSurat)
    {
        $this->bidangSurat = $bidangSurat;
    }

    public function query()
    {
        return SuratMasuk::where('bidang_surat', $this->bidangSurat);
    }

    public function headings(): array
    {
        return [
            'NO',
            'ID',
            'Bidang Surat',
            'Kategori Surat',
            'Tanggal Terima Surat',
            'No Agenda',
            'Nomor Surat',
            'Tanggal Surat',
            'Asal Surat',
            'Perihal Isi Surat',
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
            $suratMasuk->bidang_surat,
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
        $sheet->getStyle('A1:N1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'],
            ],
        ]);

        $sheet->getStyle('A1:N' . $sheet->getHighestRow())->applyFromArray([
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
