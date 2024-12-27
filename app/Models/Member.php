<?php

namespace App\Models;

use App\Models\User;
use App\Models\TopsProfile;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Models\CircleCall;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        // 'email',
        'userId',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function visitorInvites()
    {
        return $this->hasMany(VisitorsDetails::class, 'invitedBy', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(ContactDetails::class, 'id', 'memberId');
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

    public function cicleCall()
    {
        return $this->hasMany(CircleCall::class, 'memberId', 'id');
    }

    public function refGive()
    {
        return $this->hasOne(CircleMeetingMembersReference::class, 'memberId', 'id');
    }

    public function circleMember()
    {
        return $this->hasOne(CircleMember::class, 'memberId', 'id');
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circleId', 'id');
    }

    public function bCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'businessCategoryId', 'id');
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'memberId', 'userId');
    }

    public function mType()
    {
        return $this->belongsTo(MembershipType::class, 'membershipType', 'id');
    }

    public function circles()
    {
        return $this->belongsTo(Circle::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }

    public function members()
    {
        return $this->belongsTo(Member::class, 'sponsoredBy');
    }
}
