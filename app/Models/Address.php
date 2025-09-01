<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'gov_id',
        'region_id',
        'title_name',
        'street',
        'block',
        'building',
        'avenue',
        'flat',
        'role',
        'area_id',
        'apartment_no'
    ];

    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }

    public function city(){
        return $this->belongsTo(City::class ,'city_id');
    }

    public function area(){
        return $this->belongsTo(Area::class ,'area_id');
    }
}
