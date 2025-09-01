<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PENDING_STATUS=0;
    const CANCELED_STATUS=1;
    const COMPLETED_STATUS=2;
    const PROGRESS_STATUS=3;

    const CASH_PAYMENT=0;
    const ONLINE_PAYMENT=1;

    public function products(){
        return $this->hasMany(OrderProduct::class ,'order_id');
    }

    public function address(){
        return $this->hasOne(OrderAddress::class ,'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
