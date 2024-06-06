<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'status',
        'payment_id'
    ];
    
    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
    public function unregOrders()
    {
        return $this->belongsTo(UnregOrder::class);
    }
}

