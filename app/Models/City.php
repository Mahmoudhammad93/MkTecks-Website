<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $hidden = [
    //     'name_ar',
    //     'name_en',
    // ];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        if (Lang() == "ar") {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function areas()
    {
        return $this->hasMany(Area::class, 'city_id');
    }
}
