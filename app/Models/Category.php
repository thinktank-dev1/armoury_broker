<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'slug',
        'category_image',
        'featured',
        'status',
        'regulated',
        'measurement_type',
    ];

    public function sub_cats(){
        return $this->hasMany(SubCategory::class);
    }
}
