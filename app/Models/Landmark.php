<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'cityId',
        'name',
        'status',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId', 'id');
    }
}
