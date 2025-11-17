<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Keluarga extends Model
{
    /** @use HasFactory<\Database\Factories\KeluargaFactory> */
    use HasFactory;

  
    protected $primaryKey = 'KK_ID';

    
    public $incrementing = false;

    
    protected $keyType = 'string';

   

  protected $fillable = [
        'KK_ID',
        'Alamat',
        'NIK_Kepala_Keluarga',
    ];


    /**
     * Relasi SATU-ke-BANYAK (One-to-Many)
     * Satu Keluarga memiliki BANYAK Warga (anggota).
     */
    public function wargas(): HasMany
    {
        // Parameter: (ModelTujuan, Foreign_Key_di_tabel_tujuan, Local_Key_di_tabel_ini)
        return $this->hasMany(Warga::class, 'KK_ID', 'KK_ID');
    }

    /**
     * Relasi SATU-ke-SATU (via BelongsTo)
     * Satu Keluarga dimiliki oleh SATU Warga sebagai Kepala Keluarga.
     */
    public function kepalaKeluarga(): BelongsTo
    {
        // Parameter: (ModelTujuan, Foreign_Key_di_tabel_ini, Owner_Key_di_tabel_tujuan)
        return $this->belongsTo(Warga::class, 'NIK_Kepala_Keluarga', 'NIK');
    }

    public function penerimaBantuans(): HasManyThrough
    {
        return $this->hasManyThrough(
            PenerimaBantuan::class,
            Warga::class,
            'KK_ID', 
            'NIK',   
            'KK_ID', 
            'NIK'    
        );
    }

}
