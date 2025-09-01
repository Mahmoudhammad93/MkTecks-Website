<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'status'
    ];

    protected $appends = [
        'name',
    ];

    public function properties(){
        return $this->hasMany(Properity::class, 'option_id');
    }

    public function propertiesApi(){
        return $this->hasMany(Properity::class, 'option_id')->whereStatus(1);
    }

    public function getNameAttribute()
    {
        if (Lang() == "ar") {
            return $this->name_ar;
        }
        return $this->name_en;
    }
}
