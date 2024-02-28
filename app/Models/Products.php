<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }
    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class, 'group');
    }
}
