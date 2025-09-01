<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $guarded = [];

    protected $hidden = [
        'display_name_ar',
        'display_name_en',
        'description_ar',
        'description_en',
    ];

    protected $appends = [
        'display_name',
        'description',
    ];

    public function getDisplayNameAttribute()
    {
        if(lang() == "ar"){
            return $this->display_name_ar;
        }
        return $this->display_name_en;
    }

    public function getDescriptionAttribute()
    {
        if(lang() == "ar"){
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function admins(){
        return $this->hasMany(RoleUser::class , 'role_id');
    }
}
