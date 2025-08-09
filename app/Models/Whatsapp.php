<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static whereWhatsappid(mixed $whatsappId)
 */
class Whatsapp extends Model
{
    protected $table = 'whatsapp';
    protected $fillable = ['id', 'whatsappId', 'session', 'studentId'];
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'NIS', 'studentId');
    }
}
