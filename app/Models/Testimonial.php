<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }
    function sender()
    {
        return $this->hasOne(Member::class,'userId','userId');
    }
    function receiver()
    {
        return $this->hasOne(Member::class,'id','memberId');
    }
}
