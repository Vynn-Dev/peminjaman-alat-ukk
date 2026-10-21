<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';
    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'merk',
        'stok',
        'kondisi',
        'foto',
        'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}