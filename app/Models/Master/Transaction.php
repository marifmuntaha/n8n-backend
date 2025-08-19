<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'trans_master';
    protected $primaryKey = 'trans_id';
    protected $fillable = [
        'trans_id',
        'tgl_trans',
        'kode_jurnal',
        'no_bukti',
        'src',
        'tob',
        'NOMINAL',
        'modul',
        'modul_trans_id',
        'KETERANGAN',
        'user_id',
        'kode_cab'
    ];

    public $timestamps = false;
}
