<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'kodejenisbiaya';
    protected $primaryKey = 'KODE_JENIS_BIAYA';
    protected $fillable = [
        'KODE_JENIS_BIAYA',
        'DESKRIPSI_JENIS_BIAYA',
        'KODE_PERK',
        'KODE_PERK_PENDAPATAN',
        'KODE_PERK_POTONGAN',
        'KODE_TRANS_TABUNGAN',
        'NO_URUT',
        'OB',
        'PERCEN_OB',
        'REK_OB'
    ];
}
