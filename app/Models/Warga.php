<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    /** @use HasFactory<\Database\Factories\WargaFactory> */
    use HasFactory;

    protected $primaryKey = 'NIK';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'NIK',
        'KK_ID',
        'Nama_Lengkap',
        'Tempat_Lahir',
        'Tanggal_Lahir',
        'Jenis_Kelamin',
        'Pekerjaan',
        'Pendidikan',
        'Status_Hubungan_Keluarga',
    ];

    public function keluarga(): BelongsTo
    {
        // Parameter: (ModelTujuan, Foreign_Key_di_tabel_ini, Owner_Key_di_tabel_tujuan)
        return $this->belongsTo(Keluarga::class, 'KK_ID', 'KK_ID');
    }
    
    /**
     * Relasi SATU-ke-BANYAK (One-to-Many)
     * Satu Warga bisa terdaftar di BANYAK program bantuan.
     */
    public function penerimaBantuans(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class, 'NIK', 'NIK');
    }
}
