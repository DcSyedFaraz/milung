<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function additionalFields()
    {
        return $this->hasMany(AdditionalField::class);
    }
    public function products()
    {
        return $this->hasMany(Products::class, 'group');
    }

    /**
     * Get the orders for the product group.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'group');
    }
}
