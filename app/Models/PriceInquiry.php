<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceInquiry extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'cargo_place' => 'array',
        'pcs' => 'array',
        'capacity' => 'array',
    ];
}
