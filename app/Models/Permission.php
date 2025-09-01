<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

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
}
