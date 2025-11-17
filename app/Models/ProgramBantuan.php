<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramBantuan extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramBantuanFactory> */
    use HasFactory;

    /**
     * Tentukan Primary Key jika namanya BUKAN 'id'.
     */
    protected $primaryKey = 'Program_ID';

    /**
     * Tentukan kolom yang boleh diisi oleh factory/mass assignment.
     */
    protected $fillable = [
        'Nama_Program',
    ];

    /**
     * Mendefinisikan relasi ke model PenerimaBantuan.
     * Satu 'ProgramBantuan' bisa memiliki banyak 'PenerimaBantuan'.
     */
    public function penerimaBantuans(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class, 'Program_ID', 'Program_ID');
    }
}
