<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    use HasFactory;

    protected $fillable = [
        'circleName',
        'userId',
        'franchiseId',
        'cityId',
        'circleTypeId',
        'meetingDay',
        'meetingTime',
    ];

    public function circletype()
    {
        return $this->belongsTo(CircleType::class, 'circletypeId', 'id');
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class, 'franchiseId', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId', 'id');
    }

    public function circleMember()
    {
        return $this->belongsTo(CircleMember::class, 'id');
    }

    public function member()
    {
        return $this->hasMany(Member::class, 'id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'circleId', 'id');
    }

    public function circleWiseMembers()
    {
        return $this->hasMany(Member::class, 'circleId', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }
}
