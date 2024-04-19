<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingInvitation extends Model
{
    use HasFactory;


    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'invitedMemberId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'invitedMemberId');
    }

    public function training()
    {
        return $this->hasOne(Training::class, 'id', 'meetingId');
    }
}
