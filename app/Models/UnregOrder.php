<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnregOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'user_address_info',
        'comment',
        'products',
        'sum',
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
