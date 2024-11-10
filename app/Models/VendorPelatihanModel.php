<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'vendor_pelatihan';
    protected $primaryKey = 'id_vendor_pelatihan';

    protected $fillable = ['nama', 'alamat', 'kota', 'no_telp', 'alamat_web'];
}
