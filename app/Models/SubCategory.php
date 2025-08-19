<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'parent_id',
        'sub_category_name',
        'slug',
    ];

    public function parent_sub(){
        return $this->belongsTo(SubCategory::class, 'parent_id');
    }
    
    public function sub_sub(){
        return $this->hasMany(SubCategory::class, 'parent_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
