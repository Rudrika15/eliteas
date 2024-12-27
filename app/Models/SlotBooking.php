<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotBooking extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }

    public function refMembers()
    {
        return $this->belongsTo(Member::class, 'refMemberId', 'id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'eventId', 'id');
    }

    public function slots()
    {
        return $this->belongsTo(Slot::class, 'slotId', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function visitors()
    {
        return $this->belongsTo(Visitor::class, 'visitorId', 'id');
    }
}
