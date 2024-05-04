<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerMaster extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'trainerId' , 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'userId' , 'id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'userId' , 'id');
    }

}
