<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public function trainer()
    {
        return $this->belongsTo(TrainerMaster::class, 'trainerId', 'id');
    }
    public function trainers()
    {
        return $this->belongsTo(TrainerMaster::class, 'trainerId', 'memberId');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'trainerId', 'userId');
    }
}
