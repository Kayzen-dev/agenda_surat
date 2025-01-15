<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        h3 {
            text-align: center;
            margin: 20px 0;
        }
        table {
            width: 95%; /* Memperkecil ukuran tabel */
            margin: 0 auto; /* Menempatkan tabel di tengah */
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 6px 8px; /* Memperkecil padding */
            text-align: left;
            font-size: 10px; /* Menyesuaikan font untuk tabel */
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
        /* Tambahkan margin untuk batas tabel */
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h3>Daftar Surat Masuk {{ $bidang_surat }}</h3>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Tanggal Terima Surat</th>
                    <th>No Agenda</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Asal Surat/Pengirim</th>
                    <th>Perihal/Isi Surat</th>
                    <th>Isi Disposisi</th>
                    <th>Surat Keluar</th>
                    <th>Kategori Surat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>

                
                @forelse($suratMasuk as $index => $surat)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="date-format">{{ \Carbon\Carbon::parse($surat->tanggal_terima_surat)->format('d-M-y') }}</td>
                        <td>{{ $surat->no_agenda }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td class="date-format">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-M-y') }}</td>
                        <td>{{ $surat->asal_surat_pengirim }}</td>
                        <td>{{ $surat->perihal_isi_surat }}</td>
                        <td>{{ $surat->isi_disposisi }}</td>
                        <td>
                            @if($surat->suratKeluar)
                                {{ $surat->suratKeluar->nomor_surat }}
                            @else
                                Tidak ada surat keluar
                            @endif
                        </td>
                        <td>{{ $surat->kategori_surat }}</td>
                        <td>{{ $surat->keterangan }}</td>
                    </tr>
                    @empty
                    <td colspan="8">Tidak Ada Surat Masuk</td>

                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
