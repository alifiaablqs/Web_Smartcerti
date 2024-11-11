<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi';    
    protected $primaryKey = 'id_sertifikasi'; 

    protected $fillable = [
        'id_vendor_sertifikasi',
        'id_jenis_sertifikasi',
        'id_periode',
        'id_bidang_minat',
        'id_matakuliah',
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

    public function jenis_sertifikasi(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_jenis_sertifikasi', 'id_jenis_sertifikasi');
    }
    
    public function periode(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_periode', 'id_periode');
    }

    public function bidang_minat_sertifikasi(): HasMany
    {
        return $this->hasMany(BidangMinatSertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }

    public function mata_kuliah_sertifikasi(): HasMany
    {
        return $this->hasMany(BidangMinatSertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
}