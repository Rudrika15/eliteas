<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleMeetingsAttendances extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'personName',
        'circleId',
        'meetingId',
        // Other fillable fields here
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId' , 'id');
    }
}
