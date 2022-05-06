<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExemption extends Model
{
    use HasFactory;
    protected $appends = ['image_url'];
    protected $with = ['image'];
    protected $fillable = [
        'state_id','user_id'
    ];
    public function image(){
        return $this->morphOne(File::class,'fileable');
    }
    public function getImageUrlAttribute(){
        if($this->image){
            return $this->image->full_url;
        }else{
            return config('app.noimage');
        }
    }
}
