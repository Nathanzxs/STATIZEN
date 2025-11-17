<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penerima Bantuan</title>
    <style>
        /* ====================================================== */
        /* PERBAIKAN: STYLE BOOTSTRAP MINI (UNTUK PDF) */
        /* ====================================================== */

        /* 1. Reset Dasar */
        body {
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #212529;
            /* Warna teks Bootstrap */
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        /* 2. Judul */
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

        /* 3. Style Tabel (Meniru .table, .table-striped, .table-bordered) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-color: #dee2e6;
            /* Warna border Bootstrap */
        }

        th,
        td {
            border: 1px solid #dee2e6;
            /* Border lebih soft */
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        /* Meniru .table-light untuk header */
        thead th {
            background-color: #f8f9fa;
            font-size: 11px;
            font-weight: bold;
            color: #495057;
            border-bottom-width: 2px;
        }

        /* Meniru .table-striped */
        tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        /* 4. Style Badge (Sudah benar) */
        .badge {
            padding: 4px 7px;
            border-radius: 4px;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
        }

        .bg-success {
            background-color: #198754;
            /* Bootstrap 5 Success */
        }

        .bg-warning {
            background-color: #ffc107;
            color: #000;
            /* Teks harus hitam untuk warning */
        }

        .bg-danger {
            background-color: #dc3545;
        }

        /* 5. Utility Classes */
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Penerima Bantuan</h1>
        <p class="tanggal-cetak">Dicetak pada: {{ $tanggalCetak }}</p>

        <!-- PERBAIKAN: Menambahkan class .table dan .table-striped -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Program Bantuan</th>
                    <th>NIK</th>
                    <th>Nama Penerima</th>
                    <th>Alamat</th>
                    <th style="width: 12%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penerimaBantuans as $index => $penerima)
                    <tr>
                        <!-- PERBAIKAN: Merapikan alignment -->
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $penerima->programBantuan->Nama_Program ?? 'N/A' }}</td>
                        <td>{{ $penerima->NIK }}</td>
                        <td>{{ $penerima->warga->Nama_Lengkap ?? 'N/A' }}</td>
                        <td>{{ $penerima->warga->keluarga->Alamat ?? 'N/A' }}</td>
                        <td class="text-center">
                            @if ($penerima->Status == 'Layak')
                                <span class="badge bg-success">{{ $penerima->Status }}</span>
                            @elseif($penerima->Status == 'Pending')
                                <!-- PERBAIKAN: Lupa `text-dark` di style sebelumnya -->
                                <span class="badge bg-warning">{{ $penerima->Status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $penerima->Status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data penerima bantuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
