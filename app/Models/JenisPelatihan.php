<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelatihan extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'jenis_pelatihan';

    // Define the primary key if it's not `id`
    protected $primaryKey = 'id_jenis_pelatihan';

    // If your primary key is not an auto-incrementing integer, set `$incrementing` to false.
    public $incrementing = true;

    // Define the data type of the primary key
    protected $keyType = 'int';

    // Specify whether timestamps are used in this table (set to `false` if not)
    public $timestamps = false;

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'nama_jenis_pelatihan',
        'kode_pelatihan'
    ];

    // Optionally, define any relationships, accessors, or mutators here
}
