<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'display_name_ar',
        'display_name_en',
    ];

    protected $appends = [
        'display_name',
    ];

    public function getDisplayNameAttribute()
    {
        if(lang() == "ar"){
            return $this->display_name_ar;
        }
        return $this->display_name_en;
    }

    public function permissions(){
        return $this->hasMany(Permission::class , 'table_id');
    }
}
