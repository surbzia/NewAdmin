<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $with =['image'];
    protected $appends = ['not_found'];
    protected $fillable = [
        'attribute_1','attribute_2','attribute_3','attribute_1_value','attribute_2_value','attribute_3_value','sku','stock','is_active'
    ];

    public function image(){
        return $this->morphOne(File::class,'fileable');
    }
    public function getNotFoundAttribute()
    {
        return asset('general/not_found.png');
    }
}
