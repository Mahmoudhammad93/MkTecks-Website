<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loyality extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }

    public function getDescriptionAttribute()
    {
        if (Lang() == "ar") {
            return $this->description_ar;
        }
        return $this->description_en;
    }

}
