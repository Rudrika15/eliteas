<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate',
        // 'email',
        'userId',
    ];

    public function sponsored()
    {
        return $this->hasMany(Member::class, 'sponsoredBy', 'id');
    }

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
    public function galleries()
    {
        return $this->hasMany(MemberGallery::class);
    }
    public function sponsors()
    {
        return $this->belongsTo(Member::class, 'sponsoredBy');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId');
    }

    public function sponsees()
    {
        return $this->hasMany(Member::class, 'sponsoredBy', 'id');
    }

    public function businessReceived()
    {
        return $this->hasMany(CircleMeetingMembersBusiness::class, 'loginMemberId', 'userId');
    }
    public function memberGallery()
    {
        return $this->hasMany(MemberGallery::class, 'memberId');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'memberId');
    }
}
