<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'title',
        'description',
    ];

    public function getTitleAttribute()
    {
        if (Lang() == "ar") {
            return $this->title_ar;
        }
        return $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        if (Lang() == "ar") {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
