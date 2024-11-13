<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'vendor_sertifikasi';
    protected $primaryKey = 'id_vendor_sertifikasi';

    protected $fillable = ['nama', 'alamat', 'kota', 'no_telp', 'alamat_web'];

    public function sertifikasi(): HasMany {
        return $this->hasMany(SertifikasiModel::class, 'id_vendor_sertifikasi', 'id_vendor_sertifikasi');
    }
}
