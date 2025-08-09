<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'sistrans';
    protected $primaryKey = 'SISTRANS_ID';
    public $timestamps = false;

    protected $fillable = [
        'SISTRANS_ID',
        'NIS',
        'TGL_TRANS',
        'MY_KODE_TRANS',
        'KUITANSI',
        'SALDO_TRANS',
        'KETERANGAN'
    ];
}
