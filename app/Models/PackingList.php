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
        return $this->belongsTo(Order::class,'order_id')->select('id','group','quantity_unit');
    }
    public function supplierid()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','userid');
    }
}
