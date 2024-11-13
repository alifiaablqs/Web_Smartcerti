<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelatihan';
    protected $primaryKey = 'id_jenis_pelatihan';

    protected $fillable = ['nama_jenis_pelatihan', 'kode_pelatihan'];

    public function pelatihan(): HasMany
    {
        return $this->hasMany(BidangMinatModel::class, 'id_jenis_pelatihan', 'id_jenis_pelatihan');
    }
}
