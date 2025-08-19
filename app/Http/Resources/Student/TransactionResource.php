<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $student
 * @property mixed $product
 */
class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'SISTRANS_ID' => $this['SISTRANS_ID'],
            'TGL_TRANS' => $this['TGL_TRANS'],
            'NIS' => $this['NIS'],
            'KODE_BIAYA' => $this['KODE_BIAYA'],
            'KODE_TRANS' => $this['KODE_TRANS'],
            'SALDO_TRANS' => $this['SALDO_TRANS'],
            'MY_KODE_TRANS' => $this['MY_KODE_TRANS'],
            'KUITANSI' => $this['KUITANSI'],
            'KODE_PERK' => $this['KODE_PERK'],
            'NO_TELLER' => $this['NO_TELLER'],
            'USERID' => $this['USERID'],
            'TOB' => $this['TOB'],
            'POSTED' => $this['POSTED'],
            'VALIDATED' => $this['VALIDATED'],
            'KETERANGAN' => $this['KETERANGAN'],
            'KODE_UNIT' => $this['KODE_UNIT'],
            'student' => $this->student,
            'product' => $this->product,
        ];
    }
}
