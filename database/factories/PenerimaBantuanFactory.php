<?php

namespace Database\Factories;

use App\Models\ProgramBantuan;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenerimaBantuan>
 */
class PenerimaBantuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'NIK' => Warga::factory(), 
            'Program_ID' => ProgramBantuan::factory(),
            'Status' => $this->faker->randomElement(['Layak', 'Tidak Layak', 'Diproses']),
        ];
    }
}
