<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliahSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'detail_mata_kuliah_sertifikasi';

    protected $primary = 'id_sertifikasi';

    protected $fillable = [
        'id_matakuliah'
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(BidangMinatModel::class, 'id_matakuliah', 'id_matakuliah');
    }

    public function sertifikasi()
    {
        return $this->belongsTo(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
}
