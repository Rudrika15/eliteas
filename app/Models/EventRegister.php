<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegister extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'eventId', 'id');
    }
}
