<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId', 'id');
    }
}
