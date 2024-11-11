<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi';    
    protected $primaryKey = 'id_sertifikasi'; 

    protected $fillable = [
        'id_vendor_sertifikasi',
        'id_vendor_pelatihan',
        'id_periode',
        'nama_sertifikasi',
        'no_sertifikasi',
        'jenis',
        'tanggal',
        'bukti_sertifikasi',
        'masa_berlaku',
        'kuota_peserta',
        'biaya',
        'created_at',
        'updated_at'
    ];

    public function vendor_sertifikasi(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_vendor_sertifikasi', 'id_vendor_sertifikasi');
    }

    public function vendor_pelatihan(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_vendor_pelatihan', 'id_vendor_pelatihan');
    }
    
    public function periode(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_periode', 'id_periode');
    }
}