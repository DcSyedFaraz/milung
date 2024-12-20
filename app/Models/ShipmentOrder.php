<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ShipmentOrder extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(BuyerProfile::class, 'buyerid')->select('id', 'buyer_id','consignee');
    }
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'so_number');
    }
    public function shipmentsupplier()
    {
        return $this->hasMany(ShipmentSupplier::class);
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
