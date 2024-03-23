<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleMeetingMembersBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'businessGiver',
        'loginMember',
        'amount',
        'date',
        'status',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId');
    }
}
