<?php

namespace Database\Factories;

use App\Models\Keluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'NIK' => $this->faker->unique()->numerify('################'), // 16 digit NIK
            'KK_ID' => Keluarga::factory(), // Otomatis membuat Keluarga baru & memakai KK_ID nya
            'Nama_Lengkap' => $this->faker->name(),
            'Tempat_Lahir' => $this->faker->city(),
            'Tanggal_Lahir' => $this->faker->date(),
            'Jenis_Kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'Pekerjaan' => $this->faker->randomElement(['IRT', 'Pelajar/Mahasiswa', 'Wiraswasta', 'Karyawan Swasta', 'PNS', 'Petani', 'Tidak Bekerja']),
            'Pendidikan' => $this->faker->randomElement(['SLTA/Sederajat', 'S1', 'D3', 'SLTP/Sederajat', 'SD/Sederajat', 'Belum Sekolah']),
            'Status_Hubungan_Keluarga' => $this->faker->randomElement(['Kepala Keluarga', 'Istri', 'Anak']),
        ];
    }
}
