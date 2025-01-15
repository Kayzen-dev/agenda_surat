<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-align: center;
        }
        td {
            vertical-align: top;
        }
        .center {
            text-align: center;
        }
        .date-format {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <h3>Daftar Surat Keluar {{ $bidang_surat }}</h3>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>Tanggal Kirim Surat</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
                <th>Tujuan Surat</th>
                <th>Perihal/Isi Surat</th>
                <th>Keterangan</th>
                <th>Kategori Surat</th>
                <th>Surat Masuk</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suratKeluar as $index => $surat)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="date-format">{{ \Carbon\Carbon::parse($surat->tanggal_kirim_surat)->format('d-M-y') }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td class="date-format">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-M-y') }}</td>
                <td>{{ $surat->tujuan_surat }}</td>
                <td>{{ $surat->perihal_isi_surat }}</td>
                <td>{{ $surat->keterangan }}</td>
                <td>{{ $surat->kategori_surat }}</td>
                <td>
                    @if($surat->suratMasuk)
                        {{ $surat->suratMasuk->nomor_surat }} - {{ $surat->suratMasuk->asal_surat_pengirim }}
                    @else
                        Tidak ada surat masuk
                    @endif
                </td>
            </tr>
            @empty
                <td colspan="8">Tidak Ada Surat Keluar</td>
            @endforelse

        </tbody>
    </table>
</body>
</html>
