<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'quantity',
        'image',
        'price',
        'category_id'
    ];
  use SoftDeletes;
  public function category():BelongsTo{
    return $this->belongsTo(Category::class);

  }
}
