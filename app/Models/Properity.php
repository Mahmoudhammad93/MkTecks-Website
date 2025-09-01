<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properity extends Model
{
    use HasFactory;

    protected $table = 'properties';

    protected $fillable = [
        'option_id',
        'name_ar',
        'name_en',
        'price',
        'status',
    ];

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
}
