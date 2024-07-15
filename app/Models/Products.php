<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $casts = [
    //     'color' => 'array',
    //     'material' => 'array',
    //     'accessory' => 'array',
    // ];
    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }
    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class, 'group');
    }
    public function printAreas()
    {
        return $this->hasMany(PrintArea::class);
    }
    public function quotes()
    {
        return $this->hasMany(ProductQuotation::class,'product_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'article','article')->select('article','supplier','id','quantity_unit','totalvalue');
    }
}
