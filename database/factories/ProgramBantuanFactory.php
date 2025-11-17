<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramBantuan>
 */
class ProgramBantuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Membuat nama program yang unik dan realistis
            'Nama_Program' => $this->faker->unique()->randomElement([
                'Bantuan Langsung Tunai (BLT) Desa',
                'Bantuan Pangan Non-Tunai (BPNT)',
                'Program Keluarga Harapan (PKH)',
                'Bantuan Subsidi Upah (BSU)',
                'Bantuan UMKM Produktif (BPUM)',
            ]) . ' ' . $this->faker->year(),
        ];
    }
}
