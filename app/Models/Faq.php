<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'parent_id',
        'content',
        'sort_order',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Faq::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Faq::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function childrenRecursive(){
        return $this->children()->with('childrenRecursive');
    }
}
