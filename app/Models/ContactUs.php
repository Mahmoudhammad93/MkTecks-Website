<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reply(){
        return $this->hasOne(ContactUsReplay::class , 'contact_id');
    }
}
