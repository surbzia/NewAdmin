<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use HasFactory;
    protected $with = ['reference'];
    protected $fillable = [
        'product_id','reference_product'
    ];
    public function reference(){
        return $this->belongsTo(Product::class,'reference_product');
    }
}
