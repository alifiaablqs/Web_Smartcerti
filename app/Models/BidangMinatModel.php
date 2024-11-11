<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangMinatModel extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'bidang_minat';

    protected $primaryKey = 'id_bidang_minat';

    protected $fillable = ['nama_bidang_minat', 'kode_bidang_minat'];
}
