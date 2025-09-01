<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = [
        'name',
        'description',
        'in_wishlist',
    ];

    protected $guarded = [];

    public function getInWishlistAttribute()
    {
        $data = Wishlist::where(['user_id'=>userLogin() ,'product_id'=>$this->id])->first();
        if($data){
            return true;
        }
        return false;
    }

    public function getNameAttribute()
    {
        if (Lang() == "ar") {
            return $this->name_ar;
        }
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        if (Lang() == "ar") {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function images3()
    {
        return $this->hasMany("App\Models\Media", 'mediaable_id')->where('mediaable_type','App\Models\Product')->take(3);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    public function orders()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id')->where('user_id',userLogin());
    }

    public function pos_carts()
    {
        return $this->hasMany(PosCartProduct::class, 'product_id');
    }

    public function components(){
        return $this->hasMany(Component::class);
    }

    public function extras(){
        return $this->hasMany(Extra::class);
    }

    public function drinks(){
        return $this->hasMany(Drink::class);
    }

    public function options(){
        return $this->hasMany(ProductOption::class);
    }

}
