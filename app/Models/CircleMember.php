<?php

namespace App\Models;

use App\Models\Circle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CircleMember extends Model
{
    use HasFactory;

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'id');
    }
    public function member()
    {
        return $this->belongsTo(Circle::class, 'id');
    }
}
