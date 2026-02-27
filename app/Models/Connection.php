<?php

namespace App\Models;

// use App\Models\Connection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Connection extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'userId');
    }

    public function members()
    {
        return $this->belongsTo(Member::class, 'userId', 'userId');
    }

    public function memberProfile()
    {
        return $this->belongsTo(Member::class, 'memberId', 'userId');
    }

    public function getConnectedUserAttribute()
    {
        $userId = Auth::id();
        if ($this->userId == $userId) {
            return $this->receiver;
        }

        return $this->user;
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'memberId', 'id');
    }

    public function receiverMember()
    {
        return $this->hasOne(Member::class, 'userId', 'memberId'); // userId in members == memberId in connections
    }

    public function getConnectedMemberAttribute()
    {
        $userId = Auth::id();
        if ($this->userId == $userId) {
            return $this->member;
        }

        return $this->members;
    }
}
