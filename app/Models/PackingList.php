<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsTo(Order::class,'order_id')->select('id','group','quantity_unit','totalvalue','sellingprice');
    }
    public function supplierid()
    {
        return $this->belongsTo(SupplierProfile::class,'user_id')->select('id','supplier_id');
    }
}
