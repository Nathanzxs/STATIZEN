<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerimaBantuan extends Model
{
    /** @use HasFactory<\Database\Factories\PenerimaBantuanFactory> */
    use HasFactory;

    /**
     * Tentukan Primary Key jika namanya BUKAN 'id'.
     */
    protected $primaryKey = 'Penerima_ID';

    /**
     * Tentukan kolom yang boleh diisi oleh factory/mass assignment.
     */
    protected $fillable = [
        'NIK',
        'Program_ID',
        'Status',
    ];

    /**
     * Mendefinisikan relasi ke model Warga.
     * Satu data 'PenerimaBantuan' dimiliki oleh satu 'Warga'.
     */
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'NIK', 'NIK');
    }

    /**
     * Mendefinisikan relasi ke model ProgramBantuan.
     * Satu data 'PenerimaBantuan' merujuk ke satu 'ProgramBantuan'.
     */
    public function programBantuan(): BelongsTo
    {
        return $this->belongsTo(ProgramBantuan::class, 'Program_ID', 'Program_ID');
    }
}
