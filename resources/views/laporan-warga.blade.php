<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Warga per Keluarga</title>
    <style>
        /* ====================================================== */
        /* STYLE BOOTSTRAP MINI (UNTUK PDF) */
        /* ====================================================== */
        body {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #212529;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 5px;
        }

        .tanggal-cetak {
            font-size: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-color: #dee2e6;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 7px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        thead th {
            background-color: #f8f9fa;
            font-size: 10px;
            font-weight: bold;
            color: #495057;
            border-bottom-width: 2px;
            text-transform: uppercase;
        }

        /* Style untuk baris header Keluarga */
        .keluarga-header-row {
            background-color: #e9ecef;
            /* Warna abu-abu terang */
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Data Warga per Keluarga</h1>
        <p class="tanggal-cetak">Dicetak pada: {{ $tanggalCetak }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 15%;">NIK</th>
                    <th>Nama Lengkap</th>
                    <th style="width: 15%;">Jenis Kelamin</th>
                    <th style="width: 15%;">Status Hubungan</th>
                    <th style="width: 15%;">Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($keluargas as $keluarga)
                    <tr class="keluarga-header-row">
                        <td colspan="2">
                            No. KK: <strong>{{ $keluarga->KK_ID }}</strong>
                        </td>
                        <td colspan="3">
                            Kepala Keluarga: <strong>{{ $keluarga->kepalaKeluarga->Nama_Lengkap ?? 'N/A' }}</strong>
                            <br><span class="text-muted">Alamat: {{ $keluarga->Alamat }}</span>
                        </td>
                    </tr>

                    @forelse ($keluarga->wargas->sortBy('Status_Hubungan_Keluarga') as $warga)
                        <tr>
                            <td>{{ $warga->NIK }}</td>
                            <td>{{ $warga->Nama_Lengkap }}</td>
                            <td>{{ $warga->Jenis_Kelamin }}</td>
                            <td>{{ $warga->Status_Hubungan_Keluarga }}</td>
                            <td>{{ $warga->Pekerjaan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 10px;">
                                Tidak ada anggota terdaftar untuk keluarga ini.
                            </td>
                        </tr>
                    @endforelse

                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 10px;">
                            Tidak ada data keluarga yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
