<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        // 'email',
        'userId',
    ];

    public function contact()
    {
        return $this->belongsTo(ContactDetails::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'memberId', 'id');
    }

    public function contactDetails()
    {
        return $this->hasOne(ContactDetails::class, 'memberId', 'id');
    }

    public function topsProfile()
    {
        return $this->hasOne(TopsProfile::class, 'memberId', 'id');
    }
}
