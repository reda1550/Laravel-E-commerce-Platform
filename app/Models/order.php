<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable=[
        "user_id", 
            "product_name",
            "qty",
            "price",
            "total",
            "paid", 
            "delivered",
            'adress',
            'phone',
            'getTotale',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
