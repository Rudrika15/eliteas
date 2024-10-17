<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function member()
    {
        return $this->hasOne(Member::class, 'userId');
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'memberId');
    }

    public function contactDetails()
    {
        return $this->hasOne(ContactDetails::class, 'memberId');
    }

    public function topsProfile()
    {
        return $this->hasOne(TopsProfile::class, 'memberId');
    }

    public function franchise()
    {
        return $this->hasOne(Franchise::class, 'userId');
    }

    public function user()
    {
        return $this->hasOne(Member::class, 'userId');
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'userId', 'id');
    }
}
