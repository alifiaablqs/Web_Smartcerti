<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BidangMinatModel extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'bidang_minat';

    protected $primaryKey = 'id_bidang_minat';

    protected $fillable = ['nama_bidang_minat', 'kode_bidang_minat'];

    public function sertifikasi(): BelongsToMany
    {
        return $this->belongsToMany(
            SertifikasiModel::class,
            'detail_bidang_minat_sertifikasi', // Nama tabel pivot
        );
    }
    public function pelatihan(): BelongsToMany
    {
        return $this->belongsToMany(
            PelatihanModel::class,
            'detail_bidang_minat_pelatihan', // Nama tabel pivot
        );
    }
}
