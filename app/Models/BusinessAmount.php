<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAmount extends Model
{
    use HasFactory;

    public function circleBusiness()
    {
        return $this->belongsTo(CircleMeetingMembersBusiness::class, 'id', 'circleMeetingMemberBusinessId');
    }

}
