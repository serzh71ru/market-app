<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'description',
        'order_id',
        'unreg_order_id',
        'user_name',
        'user-id',
        'order_type',
        'status'
    ];
}

