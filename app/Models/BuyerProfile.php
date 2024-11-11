<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class BuyerProfile extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    protected $guarded = [];

    protected $casts = [
        'group' => 'array',
        'sec_group' => 'array',
    ];
    public function shouldBeSearchable()
    {
        return !$this->trashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function person()
    {
        return $this->hasMany(User::class, 'buyer_id')->select('id', 'buyer_id', 'userid', 'email', 'name', 'status');
    }
}
