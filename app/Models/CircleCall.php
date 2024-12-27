<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleCall extends Model
{
    protected $table = 'circle_meeting_members_121';
    use HasFactory;

    protected $fillable = [
        'userId',
        'memberId',
        'meetingPersonId',
        'meetingPlace',
        'remarks',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'userId');
    }
    public function meetingPerson()
    {
        return $this->belongsTo(Member::class, 'meetingPersonId', 'userId');
    }

    public function meetPerson()
    {
        return $this->belongsTo(Member::class, 'meetingPersonId', 'memberId');
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circleId', 'id');
    }



}
