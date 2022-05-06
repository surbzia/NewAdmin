<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductAttribute extends Model
{
    use HasFactory;
    protected $with = ['attribute_values'];
    protected $fillable = [];
    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($attribute) {
            $attribute->attribute_values()->delete();
        });
    }
}
