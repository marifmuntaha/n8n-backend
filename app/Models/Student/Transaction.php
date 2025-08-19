<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'sistrans';
    protected $primaryKey = 'SISTRANS_ID';
    public $timestamps = false;

    protected $fillable = [
        'SISTRANS_ID',
        'TGL_TRANS',
        'NIS',
        'KODE_BIAYA',
        'KODE_TRANS',
        'SALDO_TRANS',
        'MY_KODE_TRANS',
        'KUITANSI',
        'KODE_PERK',
        'NO_TELLER',
        'USERID',
        'TOB',
        'POSTED',
        'VALIDATED',
        'KETERANGAN',
        'KODE_UNIT'
    ];
}
