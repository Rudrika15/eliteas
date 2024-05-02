<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public function trainer()
    {
        return $this->belongsTo(TrainerMaster::class, 'trainingId', 'id');
    }
    public function trainers()
    {
        return $this->hasMany(TrainingTrainers::class, 'trainingId', 'id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'trainerId', 'userId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'trainerId', 'id');
    }

    public function registerTraining()
    {
        return $this->hasMany(TrainingRegister::class, 'trainingId', 'id');
    }

    public function trainersTrainings()
    {
        return $this->belongsTo(TrainingTrainers::class, 'id');
    }
}
