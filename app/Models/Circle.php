<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    use HasFactory;

    protected $fillable = [
        'circleName',
        'franchiseId',
        'cityId',
        'circleTypeId',
        'meetingDay',
        'meetingTime',
    ];

    public function circletype()
    {
        return $this->belongsTo(CircleType::class, 'id');
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class, 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'id');
    }

}
