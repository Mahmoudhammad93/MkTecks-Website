<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'order',
        'status'
    ];

    protected $appends = [
        'title',
        'description'
    ];

    public function getTitleAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->title_ar;
        }
        return $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
