<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierProfile extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'group' => 'array',
        'sec_group' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function person()
    {
        return $this->hasMany(User::class,'supplier_id')->select('id','supplier_id','userid','email','name','status');
    }
}
