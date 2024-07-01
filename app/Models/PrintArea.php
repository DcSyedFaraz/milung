<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintArea extends Model
{
    use HasFactory;
    protected $fillable = ['position', 'size', 'method'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
