<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $hidden = [
    //     'name_ar',
    //     'name_en',
    //     'address_ar',
    //     'address_en',
    //     'keywords_ar',
    //     'keywords_en',
    //     'description_ar',
    //     'description_en',
    //     'about_ar',
    //     'about_en',
    //     'terms_ar',
    //     'terms_en',
    //     'privacy_ar',
    //     'privacy_en',
    // ];

    protected $appends = ['name','address','keywords','description','about','terms','privacy', 'header_message', 'header_title', 'header_description'];

    public function getNameAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getAddressAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->address_ar;
        }
        return $this->address_en;
    }

    public function getKeywordsAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->keywords_ar;
        }
        return $this->keywords_en;
    }

    public function getDescriptionAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function getAboutAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->about_ar;
        }
        return $this->about_en;
    }

    public function getTermsAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->terms_ar;
        }
        return $this->terms_en;
    }

    public function getPrivacyAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->privacy_ar;
        }
        return $this->privacy_en;
    }

    public function getHeaderMessageAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->header_message_ar;
        }
        return $this->header_message_en;
    }

    public function getHeaderTitleAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->header_title_ar;
        }
        return $this->header_title_en;
    }

    public function getHeaderDescriptionAttribute()
    {
        if (app()->getLocale() == "ar") {
            return $this->header_description_ar;
        }
        return $this->header_description_en;
    }
}
