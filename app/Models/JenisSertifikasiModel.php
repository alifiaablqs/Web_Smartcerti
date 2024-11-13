<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'jenis_sertifikasi';
    protected $primaryKey = 'id_jenis_sertifikasi';

    protected $fillable = ['nama_jenis_sertifikasi', 'kode_jenis_sertifikasi'];

    public function sertifikasi(): HasMany
    {
        return $this->hasMany(BidangMinatModel::class, 'id_jenis_sertifikasi', 'id_jenis_sertifikasi');
    }
}
