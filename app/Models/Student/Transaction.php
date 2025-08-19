<?php

namespace App\Models\Student;

use App\Models\Product;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'NIS', 'NIS');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'KODE_JENIS_BIAYA', 'KODE_BIAYA');
    }
}
