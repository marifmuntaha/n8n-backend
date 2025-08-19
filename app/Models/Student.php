<?php

namespace App\Models;

use App\Models\Student\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $NIS
 * @property mixed $NAMA_SISWA
 * @property mixed $STATUS
 */
class Student extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'NIS';
    protected $fillable = [
        'NIS',
        'NAMA_SISWA',
        'ALAMAT',
        'KOTA',
        'JNS_KELAMIN',
        'TEMPATLAHIR',
        'TGLLAHIR',
        'WALI_MURID',
        'TELPON_WALI',
        'NAMA_AYAH',
        'NAMA_IBU',
        'STATUS',
        'KELAS',
        'SALDO_TABUNGAN',
        'TAGIHAN_BIAYA',
        'BOARDING',
        'SUBBOARDING',
        'KODE_CABANG'
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'NIS', 'NIS');
    }
}
