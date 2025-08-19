<?php

namespace App\Models\Teller;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'tellertrans';
    protected $primaryKey = 'trans_id';
    protected $fillable = [
        'trans_id',
        'modul',
        'tgl_trans',
        'kode_jurnal',
        'no_bukti',
        'uraian',
        'my_kode_trans',
        'saldo_trans',
        'tob',
        'modul_trans_id',
        'kode_perk',
        'kode_perk2',
        'pengguna',
        'userid',
        'VALIDATED',
        'POSTED',
        'kode_cab',
        'KODE_KANTOR',
        'kode_unit'
    ];

    public $timestamps = false;
}
