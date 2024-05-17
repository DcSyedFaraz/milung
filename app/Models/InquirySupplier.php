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
        return $this->belongsTo(PriceInquiry::class, 'price_inquiry_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userid()
    {
        return $this->belongsTo(User::class,'user_id','id')->select('id','userid');
    }
    public function supplierremarks()
    {
        return $this->belongsTo(SupplierRemarks::class,'user_id','user_id')->select('user_id','remarks');
    }
}
