<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'circleId',
        'day',
        'date',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circleId', 'id');
    }
}
