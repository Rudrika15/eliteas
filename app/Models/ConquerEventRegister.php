<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConquerEventRegister extends Model
{
    use HasFactory;


    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function events()
    {
        return $this->belongsTo(ConquerEvent::class, 'eventId', 'id');
    }
}
