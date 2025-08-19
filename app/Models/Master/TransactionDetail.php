<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionDetail extends Model
{
    protected $table = 'trans_detail';
    protected $primaryKey = 'trans_id';

    protected $fillable = [
        'trans_id',
        'master_id',
        'uraian',
        'kode_perk',
        'perk_pembantu',
        'debet',
        'kredit',
        'saldo_akhir',
        'src',
        'modul',
        'kode_cab',
        'tgl_trans_dtl',
        'no_rek'
    ];

    public $timestamps = false;

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'trans_id', 'master_id');
    }
}
