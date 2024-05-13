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

    public function businessGiver()
    {
        return $this->belongsTo(User::class, 'businessGiverId');
    }
    public function loginMember()
    {
        return $this->belongsTo(User::class, 'loginMemberId');
    }

    // public function circleBusiness()
    // {
    //     return $this->belongsTo(BusinessAmount::class, 'id', 'circleMeetingMemberBusinessId');
    // }

    
}
