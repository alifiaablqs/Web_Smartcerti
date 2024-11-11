<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangMinatSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'detail_bidang_minat_sertifikasi';

    protected $primary = 'id_sertifikasi';

    protected $fillable = [
        'id_bidang_minat'
    ];

    public function bidangMinat()
    {
        return $this->belongsTo(BidangMinatModel::class, 'id_bidang_minat', 'id_bidang_minat');
    }

    public function sertifikasi()
    {
        return $this->belongsTo(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
}
