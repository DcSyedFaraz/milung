<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'buyerid')->select('id','userid');
    }
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'so_number');
    }
    public function shipmentsupplier()
    {
        return $this->hasOne(ShipmentSupplier::class);
    }
    public function settleamount()
    {
        return $this->hasOne(SettleAmount::class);
    }
    public function information()
    {
        return $this->hasOne(Information::class);
    }
}
