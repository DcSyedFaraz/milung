<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'userid');
    }
    public function settleamount()
    {
        return $this->hasone(SettleAmount::class, 'shipment_order_id', 'shipment_order_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'so_number', 'shipment_order_id')->select('so_number','quantity_unit','id','totalvalue','sellingprice','buyer');
    }
    // public function orderssome()
    // {
    //     return $this->hasMany(Order::class, 'so_number', 'shipment_order_id')->select('so_number','quantity_unit','id','totalvalue','sellingprice');
    // }
}
