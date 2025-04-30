<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subtotal', 'discount', 'tax', 'total',
        'name', 'phone', 'address', 'city', 'zip', 'state', 'landmark'
    ];
    public function user(){
        return $$this->belongTo(User::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

}