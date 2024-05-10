<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingTrainers extends Model
{
    use HasFactory;
    
    public $table = 'trainings_trainers';

    public function user()
    {
        return $this->belongsTo(User::class, 'userId' , 'id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'trainingId', 'id');
    }

}
