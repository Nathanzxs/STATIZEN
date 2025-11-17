<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\PenerimaBantuan;
use App\Models\ProgramBantuan;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ]);
        // === BAGIAN ANDA (SUDAH BENAR) ===

        // 1. Buat 20 Keluarga & 20 Kepala Keluarga
        $keluargas = Keluarga::factory(20)->create();
        
        $keluargas->each(function ($keluarga) {
            $kepalaKeluarga = Warga::factory()->create([
                'KK_ID' => $keluarga->KK_ID,
                'Status_Hubungan_Keluarga' => 'Kepala Keluarga'
            ]);
            $keluarga->update([
                'NIK_Kepala_Keluarga' => $kepalaKeluarga->NIK
            ]);
        });

        // 2. Buat 30 Warga (anggota keluarga) sisanya
        $jumlahWargaSisa = 30;
        $semuaKkId = $keluargas->pluck('KK_ID');

        Warga::factory($jumlahWargaSisa)
            ->state(new Sequence(
                fn () => [
                    'KK_ID' => $semuaKkId->random(),
                    'Status_Hubungan_Keluarga' => fake()->randomElement(['Istri', 'Anak'])
                ]
            ))
            ->create();

        // 3. Buat 5 Program Bantuan
        $programs = ProgramBantuan::factory(5)->create();


        // === PERBAIKAN 2: Tambahkan Seeder untuk 'PenerimaBantuan' ===

        // 4. Hubungkan Warga dengan Program Bantuan
        //    Kita akan beri 1-3 program bantuan acak ke setiap warga

        $semuaWarga = Warga::all();
        $semuaProgramId = $programs->pluck('Program_ID');

        foreach ($semuaWarga as $warga) {
            // Ambil 1, 2, atau 3 Program ID secara acak & unik
            $programIdsAcak = $semuaProgramId->shuffle()->take(rand(1, 3));

            foreach ($programIdsAcak as $programId) {
                PenerimaBantuan::factory()->create([
                    'NIK' => $warga->NIK,
                    'Program_ID' => $programId
                ]);
            }
        }
    
        
        
    }
}
