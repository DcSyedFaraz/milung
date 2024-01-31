<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerProfile extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'group' => 'array',
        'sec_group' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
