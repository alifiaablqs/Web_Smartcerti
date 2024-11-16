<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'detail_peserta_sertifikasi';

    protected $primary = 'id_sertifikasi';

    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(BidangMinatModel::class, 'user_id', 'user_id');
    }

    public function sertifikasi()
    {
        return $this->belongsTo(SertifikasiModel::class, 'id_sertifikasi', 'id_sertifikasi');
    }
}
