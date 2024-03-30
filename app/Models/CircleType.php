<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CircleType extends Model
{
    use HasFactory;

    public function circle()
    {
        return $this->hasOne(Circle::class, 'id');
    }
}
