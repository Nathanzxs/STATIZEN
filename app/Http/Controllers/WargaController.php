<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\PenerimaBantuan;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    /**
     * Menampilkan halaman form untuk menambah warga baru.
     * Ini adalah halaman 'Form Data Warga' Anda.
     */
    public function index()
    {
        // Kita jadikan 'index' sebagai halaman 'create'
        // Ini adalah implementasi "Form Data Warga" Anda (poin #2)
        
        // Ambil daftar keluarga untuk <select>
        $keluargas = Keluarga::with('kepalaKeluarga')
            ->get()
            ->map(fn($k) => [
                'value' => $k->KK_ID,
                // Tampilkan nama kepala keluarga di dropdown
                'text' => $k->kepalaKeluarga->Nama_Lengkap ?? ('KK: ' . $k->KK_ID) 
            ]);

        // (Opsional) Tampilkan juga tabel daftar semua warga
        $wargas = Warga::with('keluarga.kepalaKeluarga')->latest()->paginate(10);

        return view('warga.index', [
            'keluargas' => $keluargas,
            'wargas' => $wargas,
        ]);
    }

    public function printPDF()
    {
        // 1. Ambil SEMUA data KELUARGA, beserta relasi 'wargas' (anggota)
        //    dan 'kepalaKeluarga' (untuk nama).
        $keluargas = Keluarga::with(['wargas', 'kepalaKeluarga'])
                            ->orderBy('KK_ID')
                            ->get();

        // 2. Siapkan data untuk dikirim ke view PDF.
        $data = [
            'tanggalCetak' => date('d F Y'),
            'keluargas' => $keluargas, // Mengirim data $keluargas
        ];

        // 3. Muat view Blade 'reports.warga_pdf'.
        $pdf = Pdf::loadView('laporan-warga', $data);

        // 4. Atur ukuran kertas dan orientasi.
        $pdf->setPaper('A4', 'landscape'); // Kertas A4, orientasi landscape

        // 5. Download PDF di browser.
        return $pdf->download('laporan-data-warga-per-keluarga.pdf');
    }

    /**
     * Menyimpan data warga BARU ke keluarga YANG SUDAH ADA.
     */
    public function store(Request $request)
    {
        // 1. Validasi (Sudah Benar)
        $request->validate([
            'KK_ID' => 'required|string|exists:keluargas,KK_ID',
            'NIK' => 'required|digits:16|unique:wargas,NIK',
            'Nama_Lengkap' => 'required|string|max:255',
            'Tempat_Lahir' => 'required|string|max:100',
            'Tanggal_Lahir' => 'required|date',
            'Jenis_Kelamin' => 'required|string',
            'Pekerjaan' => 'required|string',
            'Pendidikan' => 'required|string',
            'Status_Hubungan_Keluarga' => 'required|string',
        ]);

        // 2. Cek duplikat Kepala Keluarga (Sudah Benar)
        if ($request->Status_Hubungan_Keluarga == 'Kepala Keluarga') {
            $adaKepala = Warga::where('KK_ID', $request->KK_ID)
                             ->where('Status_Hubungan_Keluarga', 'Kepala Keluarga')
                             ->exists();
            if ($adaKepala) {
                return back()->with('error', 'Keluarga ini sudah memiliki Kepala Keluarga.');
            }
        }

        // 3. Simpan data (Sudah Benar, pastikan $fillable di Model Warga lengkap)
        Warga::create($request->all());

        // 4. PERBAIKAN: Redirect kembali ke halaman index KELUARGA
        return redirect()->route('keluarga.index')
                   ->with('success', 'Warga baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data warga.
     * Ini yang akan dipakai oleh tombol 'Edit' di tabel accordion.
     */
  public function edit(Warga $warga)
    {
        // 1. Ambil SEMUA data keluarga untuk ditampilkan di tabel utama
        //    (Sama seperti di KeluargaController@index)
        $keluargas = Keluarga::with(['kepalaKeluarga', 'wargas'])
                         ->withCount('wargas')
                         ->latest()
                         ->get();
        
        // 2. Kirim semua data yang diperlukan oleh view 'keluarga.index'
        return view('keluarga.index', [
            'keluargas' => $keluargas,       // Untuk tabel & dropdown
            'keluargaToEdit' => null,       // Form keluarga dalam mode 'create'
            'wargaToEdit' => $warga,        // Form warga dalam mode 'edit'
        ]);
    }

    /**
     * Update data warga di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warga  $warga
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Warga $warga)
    {
        // 1. Validasi semua input dari form
        $validatedData = $request->validate([
            'KK_ID' => 'required|string|exists:keluargas,KK_ID',
            'NIK' => [
                'required',
                'digits:16',
                // Pastikan NIK unik, tapi abaikan NIK warga yang sedang diedit
                Rule::unique('wargas', 'NIK')->ignore($warga->NIK, 'NIK'), 
            ],
            'Nama_Lengkap' => 'required|string|max:255',
            'Tempat_Lahir' => 'required|string|max:100',
            'Tanggal_Lahir' => 'required|date',
            'Jenis_Kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'Status_Hubungan_Keluarga' => 'required|string|max:50',
            'Pekerjaan' => 'required|string|max:100',
            'Pendidikan' => 'required|string|max:100',
        ]);

        $nikLama = $warga->NIK;
        $nikBaru = $validatedData['NIK'];

        // Nonaktifkan foreign key check SEBELUM transaksi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::beginTransaction();

            // 2. Update data Warga (Induk)
            $warga->update($validatedData);

            // 3. LOGIKA EDGE CASE: UPDATE SEMUA CHILD TABLES
            if ($nikLama !== $nikBaru) {
                
                // Child Table 1: 'keluargas' (jika dia kepala keluarga)
                $keluargaTerkait = Keluarga::where('NIK_Kepala_Keluarga', $nikLama)->first();
                if ($keluargaTerkait) {
                    $keluargaTerkait->update(['NIK_Kepala_Keluarga' => $nikBaru]);
                }

                // Child Table 2: 'penerima_bantuans'
                // Update semua record bantuan yang terkait dengan NIK lama
                // (Pastikan Anda punya model 'PenerimaBantuan')
                PenerimaBantuan::where('NIK', $nikLama)->update(['NIK' => $nikBaru]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // PENTING: Aktifkan lagi check-nya meskipun gagal
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route('keluarga.edit', $warga->NIK)
                             ->with('error', 'Gagal memperbarui data warga: ' . $e->getMessage())
                             ->withInput();
        }

        // PENTING: Aktifkan lagi check-nya setelah sukses
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('keluarga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Hapus data warga.
     */
    public function destroy(Warga $warga)
    {
        // Logika pengaman: jangan biarkan Kepala Keluarga dihapus
        if ($warga->Status_Hubungan_Keluarga == 'Kepala Keluarga') {
            return back()->with('error', 'Tidak dapat menghapus Kepala Keluarga. Silakan ubah statusnya terlebih dahulu atau hapus unit Keluarga.');
        }
        
        $warga->delete();
        return back()->with('success', 'Anggota warga berhasil dihapus.');
    }
}
