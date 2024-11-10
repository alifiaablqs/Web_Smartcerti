<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'vendor_sertifikasi';
    protected $primaryKey = 'id_vendor_sertifikasi';

    protected $fillable = ['nama', 'alamat', 'kota', 'no_telp', 'alamat_web'];
}
