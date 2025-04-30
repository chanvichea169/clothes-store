<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'amount', 'mode', 'status', 'created_at', 'updated_at'
    ];


    public function order(){
        return $this->belongsTo(Order::class);
    }
}
