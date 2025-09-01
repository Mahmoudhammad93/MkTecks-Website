<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
    ];

    protected $appends = ['title', 'content', 'time_ago'];

    public function getTitleAttribute()
    {
        if (Lang() == "ar") {
            return $this->title_ar;
        }
        return $this->title_en;
    }

    public function getContentAttribute()
    {
        if (Lang() == "ar") {
            return $this->content_ar;
        }
        return $this->content_en;
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
