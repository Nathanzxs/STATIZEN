<?php

namespace App\Http\Controllers;

// Impor yang DIPERLUKAN

use App\Models\PenerimaBantuan;
use App\Models\ProgramBantuan;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramBantuanController extends Controller
{
    /**
     * Menampilkan halaman manajemen program bantuan (bantuan.blade.php)
     * (Logika diperbaiki agar sesuai dengan view 'bantuan.blade.php' yang baru)
     */
    public function index()
    {
        // 1. Ambil SEMUA program bantuan untuk tabel & dropdown.
        //    Kita juga hitung jumlah penerimanya (withCount) dan ambil data penerimanya (with) untuk tabel nested.
        //    Relasi 'penerimaBantuans' sudah diperbaiki di model.
        $programBantuans = ProgramBantuan::withCount('penerimaBantuans')
            ->with([
                'penerimaBantuans',               // Ambil data anak (penerima)
                'penerimaBantuans.warga', // Ambil data cucu (warga)
                'penerimaBantuans.warga.keluarga' // Ambil data cicit (keluarga/alamat)
            ])
            ->latest('Program_ID') // Urutkan
            ->get();

        // 2. Ambil SEMUA warga untuk dropdown "Pilih Warga"
        $wargas = Warga::select('NIK', 'Nama_Lengkap')->get();

        // 3. Kirim data ke view
        //    Kita juga kirim '...ToEdit' => null agar form
        //    berada dalam mode "create" (tambah baru).
        return view('bantuan', [
            'programBantuans' => $programBantuans,
            'wargas' => $wargas,
            'programToEdit' => null,
            'penerimaToEdit' => null,
        ]);
    }


     public function printPDF()
    {
        // 1. Ambil data yang ingin Anda cetak.
        $penerimaBantuans = PenerimaBantuan::with(['warga', 'programBantuan', 'warga.keluarga'])->where('Status', 'Layak')
            ->orderBy('Program_ID')
            ->get();

        // 2. Siapkan data untuk view
        $data = [
            'tanggalCetak' => date('d F Y'),
            'penerimaBantuans' => $penerimaBantuans,
        ];

        // 3. Muat view Blade, masukkan data, dan buat PDF
        $pdf = Pdf::loadView('laporan-bantuan   ', $data);

        // 4. Atur ukuran kertas dan orientasi (Opsional)
        $pdf->setPaper('A4', 'landscape'); // Kertas A4, orientasi landscape

        // 5. Download PDF di browser
        return $pdf->download('laporan-penerima-bantuan.pdf');
    }
    /**
     * Menyimpan program bantuan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'Nama_Program' => 'required|string|max:255|unique:program_bantuans,Nama_Program',
        ]);

        // Buat program bantuan baru
        ProgramBantuan::create($validatedData);

        return redirect()->route('bantuan.index')
            ->with('success', 'Program bantuan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit program bantuan.
     * Kita akan memuat ulang halaman index dengan data program yang akan diedit.
     */
    public function edit(ProgramBantuan $program_bantuan)
    {
        // 1. Ambil semua data yang diperlukan oleh view, sama seperti di index()
        $programBantuans = ProgramBantuan::withCount('penerimaBantuans')
            ->with(['penerimaBantuans', 'penerimaBantuans.warga', 'penerimaBantuans.warga.keluarga'])
            ->latest('Program_ID')
            ->get();

        $wargas = Warga::select('NIK', 'Nama_Lengkap')->get();

        // 2. Kirim data ke view, tapi kali ini dengan 'programToEdit'
        return view('bantuan', [
            'programBantuans' => $programBantuans,
            'wargas' => $wargas,
            'programToEdit' => $program_bantuan, // Data program yang akan diedit
            'penerimaToEdit' => null,
        ]);
    }

    /**
     * Memperbarui data program bantuan di database.
     */
    public function update(Request $request, ProgramBantuan $program_bantuan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'Nama_Program' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama unik, tapi abaikan nama program yang sedang diedit
                Rule::unique('program_bantuans', 'Nama_Program')->ignore($program_bantuan->Program_ID, 'Program_ID'),
            ],
        ]);

        // Update data
        $program_bantuan->update($validatedData);

        return redirect()->route('bantuan.index')
            ->with('success', 'Program bantuan berhasil diperbarui.');
    }

    /**
     * Menghapus program bantuan dari database.
     */
    public function destroy(ProgramBantuan $program_bantuan)
    {
        // Hapus program bantuan
        $program_bantuan->delete();

        return redirect()->route('bantuan.index')
            ->with('success', 'Program bantuan berhasil dihapus.');
    }
}