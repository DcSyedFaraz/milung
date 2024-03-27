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
        'pcs' => 'array',
        'capacity' => 'array',
        'supplier_ids' => 'array',
    ];
    public function inquirysuppliers()
    {
        return $this->hasMany(InquirySupplier::class);
    }
}
