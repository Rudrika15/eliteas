<?php

namespace App\Models;

// use App\Models\Connection;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            return $this->member;
        }
        return $this->user;
    }


}
