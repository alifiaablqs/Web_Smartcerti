<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PelatihanModel extends Model
{
    use HasFactory;

    protected $table = 'pelatihan';    
    protected $primaryKey = 'id_pelatihan'; 

    protected $fillable = [
        'id_vendor_pelatihan',
        'id_jenis_pelatihan',
        'id_periode',
        'nama_pelatihan',
        'lokasi',
        'level_pelatihan',
        'tanggal',
        'bukti_pelatihan',
        'kuota_peserta',
        'biaya',
        'created_at',
        'updated_at'
    ];

    public function vendor_pelatihan(): BelongsTo
    {
        return $this->belongsTo(VendorPelatihanModel::class, 'id_vendor_pelatihan', 'id_vendor_pelatihan');
    }

    public function jenis_pelatihan(): BelongsTo
    {
        return $this->belongsTo(JenisPelatihanModel::class, 'id_jenis_pelatihan', 'id_jenis_pelatihan');
    }
    
    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id_periode');
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(PelatihanModel::class, 'detail_peserta_pelatihan', 'id_pelatihan' ,'user_id');
    }
}