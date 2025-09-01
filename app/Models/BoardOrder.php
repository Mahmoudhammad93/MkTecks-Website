<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(){
        return $this->hasMany(BoardOrderProduct::class ,'board_order_id');
    }

    public function board(){
        return $this->belongsTo(Board::class ,'board_id');
    }

    public function transactions(){
        return $this->hasMany(BoardOrderTransaction::class ,'board_order_id');
    }

}
