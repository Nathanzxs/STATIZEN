<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KeluargaController extends Controller
{
    /**
     * Menampilkan halaman daftar keluarga (tabel accordion).
     * Ini adalah method utama untuk halaman 'manajemen keluarga'.
     */
    public function index()
    {
        // Ambil semua keluarga
        // Eager load relasi 'kepalaKeluarga' (belongsTo Warga)
        // Eager load relasi 'wargas' (hasMany Warga)
        // withCount('wargas') untuk menghitung jumlah anggota
        $keluargas = Keluarga::with(['kepalaKeluarga', 'wargas'])
            ->withCount('wargas')
            ->latest() // Urutkan berdasarkan yang terbaru
            ->get();

        // Kirim data ke view
        return view('keluarga.index', [
            'keluargas' => $keluargas
        ]);
    }

    /**
     * Menampilkan form untuk membuat keluarga baru.
     * (Dalam desain kita, form ini ada di halaman index)
     */
    public function create()
    {
        // Arahkan ke index, karena form ada di sana
        return redirect()->route('keluarga.index');
    }

    /**
     * Menyimpan data Keluarga BARU dan Kepala Keluarga BARU.
     * Ini menangani form "Tambah Keluarga Baru".
     */
  public function store(Request $request)
    {
        // 1. Validasi 4 input yang Anda minta
        //    (Nama input di form: KK_ID, nik_kepala, nama_kepala, Alamat)
        $validatedData = $request->validate([
            'KK_ID'       => 'required|digits:16|unique:keluargas,KK_ID',
            'nik_kepala'  => 'required|digits:16|unique:wargas,NIK',
            'nama_kepala' => 'required|string|max:255',
            'Alamat'      => 'required|string|max:255',
        ], [
            // Pesan error kustom (opsional tapi bagus)
            'KK_ID.unique' => 'Nomor KK ini sudah terdaftar.',
            'nik_kepala.unique' => 'NIK Kepala Keluarga ini sudah terdaftar.',
        ]);

        try {
            DB::beginTransaction();

            // 2. Siapkan data Warga (Kepala Keluarga)
            //    (Gunakan make(), jangan create() dulu)
            $kepalaKeluarga = Warga::make([
                'NIK' => $validatedData['nik_kepala'],
                'KK_ID' => $validatedData['KK_ID'], // AMBIL DARI INPUT
                'Nama_Lengkap' => $validatedData['nama_kepala'],
                'Status_Hubungan_Keluarga' => 'Kepala Keluarga',
                'Tempat_Lahir' => 'Data Belum Diisi',
                'Tanggal_Lahir' => '1970-01-01', // Default
                'Jenis_Kelamin' => 'Laki-laki',  // Asumsi, bisa ditambahkan di form
                'Pekerjaan'     => 'Belum Diisi',
                'Pendidikan'    => 'Belum Diisi',
            ]);

            // 3. Buat data INDUK (Keluarga) DULU
            //    Ini penting agar foreign key constraint (relasi) terpenuhi
            $keluarga = Keluarga::create([
                'KK_ID' => $validatedData['KK_ID'], // AMBIL DARI INPUT
                'Alamat' => $validatedData['Alamat'],
                'NIK_Kepala_Keluarga' => $validatedData['nik_kepala'],
            ]);

            // 4. Setelah induk (Keluarga) berhasil dibuat, SIMPAN data anak (Warga)
            $kepalaKeluarga->save();

            DB::commit(); // Semua sukses, simpan permanen

        } catch (\Exception $e) {
            DB::rollBack(); // Ada error, batalkan semua
            
            // Kirim pesan error yang lebih spesifik jika bisa
            if ($e->getCode() == '23000') { // Kode error database untuk duplikat
                 return redirect()->route('keluarga.index')
                           ->with('error', 'Gagal menyimpan data. NIK atau No. KK sudah terdaftar.')
                           ->withInput();
            }
            
            return redirect()->route('keluarga.index')
                           ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                           ->withInput();
        }

        // 5. Redirect dengan pesan sukses
        return redirect()->route('keluarga.index')
                      ->with('success', 'Keluarga baru (No.KK: ' . $validatedData['KK_ID'] . ') berhasil ditambahkan.');
    }


    /**
     * Menampilkan form untuk mengedit data keluarga (misal: alamat).
     */
   public function edit(Keluarga $keluarga)
{
    $keluargas = Keluarga::with(['kepalaKeluarga', 'wargas'])
                     ->withCount('wargas')
                     ->latest()
                     ->get();
    
    return view('keluarga.index', [
        // 'keluarga' => $keluarga, // <-- INI SUMBER MASALAH
        'keluargaToEdit' => $keluarga, // <-- INI SOLUSINYA
        'keluargas' => $keluargas,
    ]);
}

    /**
     * Update data keluarga di database.
     */
    public function update(Request $request, Keluarga $keluarga)
    {
        // 1. Validasi (Sudah Benar)
        $validatedData = $request->validate([
            'Alamat' => 'required|string|max:255',
            'KK_ID' => [
                'required',
                'digits:16',
                Rule::unique('keluargas', 'KK_ID')->ignore($keluarga->id), 
            ],
        ]);

        // Nonaktifkan foreign key check SEBELUM transaksi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::beginTransaction();

            $kkIdLama = $keluarga->KK_ID;
            $kkIdBaru = $validatedData['KK_ID'];

            // 2. Update data Keluarga (Induk)
            //    (Sekarang aman karena check dimatikan)
            $keluarga->update([
                'Alamat' => $validatedData['Alamat'],
                'KK_ID' => $kkIdBaru,
            ]);

            // 3. Update data Warga (Semua Anggota)
            //    (Juga aman)
            Warga::where('KK_ID', $kkIdLama)->update([
                'KK_ID' => $kkIdBaru
            ]);
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // PENTING: Aktifkan lagi check-nya meskipun gagal
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
            return redirect()->route('keluarga.edit', $keluarga->KK_ID)
                             ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                             ->withInput();
        }

        // PENTING: Aktifkan lagi check-nya setelah sukses
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('keluarga.index')
                         ->with('success', 'Data keluarga (No.KK: ' . $kkIdBaru . ') berhasil diperbarui.');
    }
}


