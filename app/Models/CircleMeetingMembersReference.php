<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleMeetingMembersReference extends Model
{
    use HasFactory;

    protected $fillable = [

        'memberId',
        'referenceGiver',
        'contactName',
        'contactNo',
        'email',
        'scale',
        'description'
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId', 'userId');
    }

    public function refGiverName()
    {
        return $this->belongsTo(User::class, 'referenceGiverId', 'id');
    }
}
