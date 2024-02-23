<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'files' => 'array',
        'packagingprinting' => 'array',
        'notice' => 'array',
        'capacity' => 'array',
        'labelFiles' => 'array',
        'logoFiles' => 'array',
        'manualFiles' => 'array',
        'safetySheetFiles' => 'array',
    ];
}
