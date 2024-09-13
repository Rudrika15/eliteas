<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circleId', 'id');
    }
}
