<?php

namespace App\Models;

// use App\Models\Connection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function members()
    {
        return $this->hasMany(Member::class, 'id', 'memberId');
    }
}
