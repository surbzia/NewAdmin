<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuote extends Model
{
    use HasFactory;
    protected $fillable = [
        'email','qty','message','product_id','is_new',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
