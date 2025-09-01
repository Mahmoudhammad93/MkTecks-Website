<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_ar',
        'position_en',
        'name',
        'status'
    ];

    protected $appends = [
        'position',
    ];

    public function getPositionAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->position_ar;
        }
        return $this->position_en;
    }

    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
