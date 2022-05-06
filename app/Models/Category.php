<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $appends = ['image_url','level_name'];
    protected $with = ['image','children'];
    protected $fillable = [
        'parent_id','name','slug','category_alias','short_description','description','is_featured','level',
        'show_in_main_menu','show_in_home_sidemenu',
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function image(){
        return $this->morphOne(File::class,'fileable');
    }
    public function parent(){
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function children(){
        return $this->hasMany(Category::class,'parent_id');
    }
    public function getImageUrlAttribute(){
        if($this->image){
            return $this->image->full_url;
        }else{
            return config('app.noimage');
        }
    }
    public function getLevelNameAttribute(){
        $name = '';
        for($i = 0; $i < $this->level; $i++){
            $name.='-';
        }
        $name.=$this->name;
        return $name;
    }
}
