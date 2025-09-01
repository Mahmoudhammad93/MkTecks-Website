<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'city_id',
        'areas'
    ];
}
