<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'studentId',
        'method',
        'merchantRef',
        'amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'order_item',
    ];
}
