<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquirySupplier extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function priceinquiry()
    {
        return $this->belongsTo(PriceInquiry::class,'price_inquiry_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
