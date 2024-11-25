<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorEventRegister extends Model
{
    use HasFactory;

    public function visitors()
    {
        return $this->belongsTo(Visitor::class, 'visitorId', 'id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'eventId', 'id');
    }
}
