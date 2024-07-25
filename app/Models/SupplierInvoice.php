<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    public function ordersInvoice()
    {
        return $this->belongsToMany(Order::class)->select('orders.id', 'orders.quantity_unit', 'orders.buyingprice', 'orders.totalvalue');
    }
    public function user()
    {
        return $this->belongsTo(SupplierProfile::class,'user_id','id');
    }
}
