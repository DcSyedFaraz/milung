<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'files' => 'array',
        'packagingprinting' => 'array',
        'notice' => 'array',
        'capacity' => 'array',
        'labelFiles' => 'array',
        'logoFiles' => 'array',
        'manualFiles' => 'array',
        'safetySheetFiles' => 'array',
    ];

    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class, 'group');
    }
    public function orderSuppliers()
    {
        return $this->hasMany(OrderSupplier::class);
    }
    public function orderSuppliersOnly()
    {
        return $this->hasOne(OrderSupplier::class);
    }
    public function buyerid()
    {
        return $this->belongsTo(User::class,'buyer')->select('id','userid');
    }
    public function supplierid()
    {
        return $this->belongsTo(User::class,'supplier')->select('id','userid');
    }
}
