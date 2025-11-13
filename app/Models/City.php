<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['cityName', 'status'];

    public function members()
    {
        return $this->hasMany(Member::class, 'cityId', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'stateId', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId', 'id');
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class, 'id');
    }
}
