<?php

namespace App\Http\Controllers;

use App\Models\PenerimaBantuan;
use App\Models\ProgramBantuan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PenerimaBantuanController extends Controller
{
    /**
     * Menyimpan data penerima bantuan baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Program_ID' => 'required|exists:program_bantuans,Program_ID',
            'NIK' => [
                'required',
                'exists:wargas,NIK',
                // Pastikan NIK ini unik UNTUK Program_ID ini
                Rule::unique('penerima_bantuans')->where(function ($query) use ($request) {
                    return $query->where('Program_ID', $request->Program_ID);
                }),
            ],
            'Status' => 'required|string|in:Pending,Layak,Tidak Layak',
        ]);

        try {
            PenerimaBantuan::create($validatedData);
            return redirect()->route('bantuan.index')->with('success', 'Penerima bantuan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('bantuan.index')
                ->with('error', 'Gagal menyimpan penerima: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan form edit untuk penerima bantuan.
     * (Harus memuat ulang semua data untuk view 'bantuan')
     */
    public function edit(PenerimaBantuan $penerimaBantuan)
    {
        // 1. Ambil SEMUA program bantuan (sama seperti di ProgramBantuanController@index)
        $programBantuans = ProgramBantuan::withCount('penerimaBantuans')
            ->with(['penerimaBantuans', 'penerimaBantuans.warga', 'penerimaBantuans.warga.keluarga'])
            ->latest('Program_ID')
            ->get();

        // 2. Ambil SEMUA warga (sama seperti di ProgramBantuanController@index)
        $wargas = Warga::select('NIK', 'Nama_Lengkap')->get();

        // 3. Kirim data ke view
        return view('bantuan', [
            'programBantuans' => $programBantuans,
            'wargas' => $wargas,
            'programToEdit' => null, // Form 1 dalam mode 'create'
            'penerimaToEdit' => $penerimaBantuan, // Form 2 dalam mode 'edit'
        ]);
    }

    /**
     * Memperbarui data penerima bantuan di database.
     */
    public function update(Request $request, PenerimaBantuan $penerimaBantuan)
    {
        $validatedData = $request->validate([
            'Program_ID' => 'required|exists:program_bantuans,Program_ID',
            'NIK' => [
                'required',
                'exists:wargas,NIK',
                // Pastikan NIK/Program_ID unik, TAPI abaikan record saat ini
                Rule::unique('penerima_bantuans')->where(function ($query) use ($request) {
                    return $query->where('Program_ID', $request->Program_ID);
                })->ignore($penerimaBantuan->Penerima_ID, 'Penerima_ID'),
            ],
            'Status' => 'required|string|in:Pending,Layak,Tidak Layak',
        ]);

        try {
            $penerimaBantuan->update($validatedData);
            return redirect()->route('bantuan.index')->with('success', 'Data penerima berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('bantuan.index')
                ->with('error', 'Gagal memperbarui penerima: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menghapus data penerima bantuan dari database.
     */
    public function destroy(PenerimaBantuan $penerimaBantuan)
    {
        try {
            $penerimaBantuan->delete();
            return redirect()->route('bantuan.index')->with('success', 'Penerima bantuan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('bantuan.index')->with('error', 'Gagal menghapus penerima: ' . $e->getMessage());
        }
    }
}