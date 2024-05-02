<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRegister extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'trainerId', 'id');
    }

    public function trainingsTrainers()
    {
        return $this->hasMany(TrainingTrainers::class, 'trainingId', 'id');
    }


}
