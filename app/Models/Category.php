<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // protected $guarded = [];

    protected $appends = [
        'name',
    ];

    public function getNameAttribute()
    {
        if (Lang() == "ar") {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function products(){
        return $this->hasMany(Product::class ,'category_id');
    }
}
