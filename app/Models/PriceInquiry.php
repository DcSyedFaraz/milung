<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceInquiry extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'cargo_place' => 'array',
        'cargo' => 'array',
        'pcs' => 'array',
        'capacity' => 'array',
        'supplier_ids' => 'array',
    ];
    public function inquirysuppliers()
    {
        return $this->hasMany(InquirySupplier::class);
    }
    public function remarks()
    {
        return $this->hasMany(SupplierRemarks::class);
    }
    public function product_group()
    {
        return $this->belongsTo(ProductGroup::class, 'group')->select('id','group_name');
    }
}
