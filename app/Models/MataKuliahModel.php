<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class MataKuliahModel extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';
    protected $primaryKey = 'id_matakuliah';

    protected $fillable = ['nama_matakuliah', 'kode_matakuliah'];

    public function sertifikasi(): BelongsToMany
    {
        return $this->belongsToMany(
            SertifikasiModel::class,
            'detail_matakuliah_sertifikasi', // Nama tabel pivot
        );
    }
    public function pelatihan(): BelongsToMany
    {
        return $this->belongsToMany(
            PelatihanModel::class,
            'detail_matakuliah_pelatihan', // Nama tabel pivot
        );
    }
}
