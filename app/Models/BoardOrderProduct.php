<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardOrderProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order(){
        return $this->belongsTo(BoardOrder::class ,'board_order_id');
    }

    public function product(){
        return $this->belongsTo(Product::class ,'product_id');
    }
}
