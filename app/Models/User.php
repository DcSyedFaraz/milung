<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LaravelPermissionToVueJS, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userid',
        'otp',
        'contact_person',
        'name',
        'email',
        'status',
        'password',
        'contact_number',
        'password_updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeWithRole($query, $roleName)
    {
        return $query->whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        });
    }

    public function supplierProfile()
    {
        return $this->hasOne(SupplierProfile::class, 'id', 'supplier_id');
    }
    public function buyerProfile()
    {
        return $this->hasOne(BuyerProfile::class, 'id', 'buyer_id');
    }
    public function inquirySupplier()
    {
        return $this->hasMany(InquirySupplier::class);
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
}
