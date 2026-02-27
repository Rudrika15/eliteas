<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleMeetingMembersBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'businessGiverId',
        'loginMemberId',
        'amount',
        'date',
        'status',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'businessGiverId', 'userId');
    }

    public function businessGiver()
    {
        return $this->belongsTo(User::class, 'businessGiverId');
    }

    public function businessGiverMember()
    {
        return $this->belongsTo(Member::class, 'businessGiverId', 'userId');
    }

    public function loginMember()
    {
        return $this->belongsTo(User::class, 'loginMemberId');
    }

    public function loginMemberReport()
    {
        return $this->belongsTo(User::class, 'loginMemberId', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'businessGiverId');
    }

    // public function circleBusiness()
    // {
    //     return $this->belongsTo(BusinessAmount::class, 'id', 'circleMeetingMemberBusinessId');
    // }

    public function reference()
    {
        return $this->belongsTo(CircleMeetingMembersReference::class, 'referenceId', 'id');
    }

    public function businessAmounts()
    {
        return $this->hasMany(BusinessAmount::class, 'circleMeetingMemberBusinessId');
    }
}
