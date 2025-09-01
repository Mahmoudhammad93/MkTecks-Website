<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $hidden = [
        'description_ar',
        'description_en',
    ];

    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        if (Lang() == "ar") {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
