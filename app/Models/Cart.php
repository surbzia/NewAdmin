<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $with = ['items'];
    protected $fillable = [
        'user_id',
        'coupon_id',
        'total',
    ];
    public function items(){
        return $this->hasMany(CartItem::class);
    }
}
