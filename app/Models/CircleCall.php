<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleCall extends Model
{
    protected $table = 'circle_meeting_members_121';
    use HasFactory;

    public function members()
    {
        return $this->belongsTo(Member::class, 'id');
    }
}
