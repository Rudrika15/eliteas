<?php

namespace App\Models;

use App\Models\Circle;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CircleMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'circleId',
        'memberId',
        // Other fillable fields here
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circleId');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'memberId');
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'id', 'memberId');
    }

    public function contactDetails()
    {
        return $this->hasOne(ContactDetails::class, 'id', 'memberId');
    }

    public function topsProfile()
    {
        return $this->hasOne(TopsProfile::class, 'id', 'memberId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'memberId');
    }
    
}
